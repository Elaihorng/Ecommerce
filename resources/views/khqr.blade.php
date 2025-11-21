{{-- resources/views/khqr_card.blade.php --}}
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>KHQR — Scan to Pay</title>
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <style>
    :root{--red:#d32f2f;--navy:#0f2530;--card-bg:#0c2530;--white:#ffffff;--muted:#9aa6ad;}
    html,body{height:100%;margin:0;font-family:Inter,system-ui,-apple-system,Helvetica,Arial,sans-serif;background:#222;}
    .wrap{min-height:100%;display:flex;align-items:center;justify-content:center;padding:24px;}
    .card{width:420px;border-radius:22px;overflow:clip;box-shadow:0 12px 30px rgba(0,0,0,.6);background:linear-gradient(180deg,var(--red) 0 72px, var(--card-bg) 72px 100%);color:var(--white);position:relative;}
    .card-header{height:72px;display:flex;align-items:center;justify-content:space-between;padding:0 20px;}
    .brand{color:var(--white);font-weight:700;letter-spacing:1px;font-size:20px;}
    .timer{font-size:14px;font-weight:600;background:rgba(0,0,0,0.2);padding:4px 10px;border-radius:8px;color:#fff;}
    .card-body{padding:18px 20px 28px 20px;background:linear-gradient(180deg, rgba(0,0,0,0.06), transparent);}
    .merchant{display:flex;justify-content:space-between;align-items:center;margin-bottom:12px;}
    .merchant .name{font-size:18px;font-weight:700;letter-spacing:1px;}
    .balance-sub{font-size:12px;color:var(--muted);margin-top:6px;}
    .qr-area{margin-top:12px;display:flex;align-items:center;justify-content:center;position:relative;padding:20px;}
    .qr-frame{background:var(--white);border-radius:16px;padding:14px;display:inline-block;}
    .qr-frame img{display:block;width:300px;height:300px;object-fit:contain;border-radius:8px;}
    .currency-badge{position:absolute;left:50%;transform:translateX(-50%);bottom:70px;background:var(--navy);color:var(--white);width:60px;height:60px;border-radius:50%;display:flex;align-items:center;justify-content:center;font-weight:700;box-shadow:0 6px 18px rgba(0,0,0,.4);border:6px solid var(--white);font-size:22px;}
    .payload{margin-top:14px;font-size:12px;color:var(--muted);word-break:break-all;padding:0 12px;text-align:center;}
    .status-msg{margin-top:12px;text-align:center;color:var(--muted);}
    .status-msg.success{color:#6ee7b7;}
    .status-msg.error{color:#ffb4b4;}
    .actions { margin-top:12px; text-align:center; }
    .btn { padding:8px 12px; border-radius:8px; border:0; cursor:pointer; font-weight:600; }
    .btn-primary { background:#28a745; color:#fff; }
    .btn-light { background:#fff; color:#222; }
    @media (max-width:480px){ .card{ width:92%; } .qr-frame img{ width:240px; height:240px; } .currency-badge{ bottom:56px; width:52px; height:52px;} }
  </style>
</head>
<body>
  <div class="wrap">
    <div class="card" role="region" aria-label="KHQR payment card">
      <div class="card-header">
        <div class="brand">KHQR</div>
        <div class="timer" id="timer">--:--</div>
      </div>

      <div class="card-body">
        <div class="merchant">
          <div>
            <div class="name">{{ strtoupper($merchant_name ?? 'MERCHANT') }}</div>
            <div class="balance-sub">Account</div>
          </div>
        </div>

        <div class="qr-area">
          <div class="qr-frame" aria-hidden="true">
            <img src="data:image/png;base64,{{ $qr_image_base64 }}" alt="KHQR code">
          </div>

          <div class="currency-badge" aria-hidden="true">
            @if(($currency ?? 'KHR') === 'USD') $ @else ៛ @endif
          </div>
        </div>

        @if(!empty($show_payload) && $show_payload)
          <div class="payload">Payload: {{ $qr_string }}</div>
          <div class="payload">MD5: {{ $md5 }}</div>
        @endif

        <div id="statusMsg" class="status-msg">Waiting for payment...</div>
        <div id="actions" class="actions"></div>
      </div>
    </div>
  </div>

<script>
(() => {
  // backend values (ensure controller passes them)
  const permit = @json($permit_number ?? null);
  const md5 = @json($md5 ?? null);
  const expiresAtIso = @json($expires_at_iso ?? null); // optional from controller
  const pollUrl = "{{ route('booking.checkPaymentAjax') }}";
  const successRedirectBase = "{{ url('/booking/success') }}"; // will append permit

  // timer: use backend expiry if provided, else fallback 15 min
  const fallbackSeconds = 15 * 60;
  let endTime = expiresAtIso ? new Date(expiresAtIso).getTime() : (Date.now() + fallbackSeconds * 1000);
  const timerEl = document.getElementById('timer');

  function updateTimerOnce() {
    const diff = endTime - Date.now();
    if (diff <= 0) {
      timerEl.textContent = 'Expired';
      timerEl.style.background = '#b71c1c';
      timerEl.style.color = '#fff';
      return true;
    }
    const m = Math.floor(diff / 60000), s = Math.floor((diff % 60000) / 1000);
    timerEl.textContent = `${String(m).padStart(2,'0')}:${String(s).padStart(2,'0')}`;
    return false;
  }
  updateTimerOnce();
  setInterval(updateTimerOnce, 1000);

  // polling config
  if (!permit) {
    document.getElementById('statusMsg').textContent = 'Missing permit number.';
    return;
  }

  const csrf = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
  let attempts = 0, maxAttempts = 120; // ~6 minutes
  const intervalMs = 3000;
  let stopped = false;

  async function checkPayment() {
    if (stopped) return;
    attempts++;
    if (attempts > maxAttempts) {
      document.getElementById('statusMsg').textContent = 'Taking too long. Please try again later.';
      return;
    }

    try {
      const res = await fetch(pollUrl, {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
          'X-CSRF-TOKEN': csrf
        },
        body: JSON.stringify({ permit_number: permit })
      });
      const json = await res.json();
      console.log('check-payment-ajax ->', json);

      if (json.status === 'paid') {
        document.getElementById('statusMsg').textContent = 'Payment confirmed. Redirecting…';
        document.getElementById('statusMsg').classList.add('success');
        stopped = true;
        setTimeout(() => window.location.href = successRedirectBase + '/' + encodeURIComponent(permit), 800);
        return;
      }

      if (json.status === 'expired') {
        document.getElementById('statusMsg').textContent = 'QR expired. Please regenerate.';
        document.getElementById('statusMsg').classList.add('error');
        stopped = true;
        showRegenerateButton();
        return;
      }

      if (json.status === 'not_found') {
        document.getElementById('statusMsg').textContent = 'No QR found on server. Please try again.';
        document.getElementById('statusMsg').classList.add('error');
        stopped = true;
        return;
      }

      if (json.status === 'error') {
        console.warn('Payment check error:', json.message);
        document.getElementById('statusMsg').textContent = 'Temporary error checking payment. Retrying...';
        document.getElementById('statusMsg').classList.add('error');
      } else {
        document.getElementById('statusMsg').textContent = 'Waiting for payment...';
      }

    } catch (e) {
      console.warn('Polling failed', e);
      document.getElementById('statusMsg').textContent = 'Network error. Retrying...';
    }

    if (!stopped) setTimeout(checkPayment, intervalMs);
  }

  function showRegenerateButton() {
    const actions = document.getElementById('actions');
    // clear previous actions
    actions.innerHTML = '';

    const form = document.createElement('form');
    form.method = 'POST';
    form.action = "{{ route('booking.payKhqr') }}";
    form.style.display = 'inline-block';

    const token = document.createElement('input');
    token.type = 'hidden';
    token.name = '_token';
    token.value = '{{ csrf_token() }}';
    form.appendChild(token);

    const permitInput = document.createElement('input');
    permitInput.type = 'hidden';
    permitInput.name = 'permit_number';
    permitInput.value = permit;
    form.appendChild(permitInput);

    const amountInput = document.createElement('input');
    amountInput.type = 'hidden';
    amountInput.name = 'amount';
    amountInput.value = "{{ $amount ?? '' }}";
    form.appendChild(amountInput);

    const currencyInput = document.createElement('input');
    currencyInput.type = 'hidden';
    currencyInput.name = 'currency';
    currencyInput.value = "{{ $currency ?? 'KHR' }}";
    form.appendChild(currencyInput);

    const btn = document.createElement('button');
    btn.type = 'submit';
    btn.className = 'btn btn-primary';
    btn.textContent = 'Regenerate QR';
    form.appendChild(btn);

    // optional: add manual check button as well
    const checkBtn = document.createElement('button');
    checkBtn.type = 'button';
    checkBtn.className = 'btn btn-light';
    checkBtn.style.marginLeft = '8px';
    checkBtn.textContent = 'Check Payment';
    checkBtn.onclick = () => { stopped = false; attempts = 0; document.getElementById('statusMsg').textContent = 'Retrying...'; checkPayment(); };

    actions.appendChild(form);
    actions.appendChild(checkBtn);
  }

  // start polling shortly after load
  setTimeout(checkPayment, 1500);
})();
</script>
</body>
</html>
