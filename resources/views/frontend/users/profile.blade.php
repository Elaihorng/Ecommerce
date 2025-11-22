@extends('frontend/layout/master')

@section('title', 'User Profile')
@section('User_avtive', 'active')

@section('header')
<header id="gtco-header" class="gtco-cover gtco-cover-xs1" role="banner" style="background-image:url('https://pppenglish.sgp1.digitaloceanspaces.com/image/large/field/image/topic-16.-khmer-national-identity-card-by-hong-menea-2.jpg');background-repeat: no-repeat;background-size: cover;background-position: center;">
    <div class="overlay"></div>
</header>
@endsection

@section('content')
<style>
    .card {
        box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        border-radius: 10px;
    }
    .nav-tabs .nav-link {
        font-weight: 600;
    }
    .tab-content .row {
        margin-bottom: 10px;
    }
    .profile-pic {
        width: 150px;
        height: 150px;
        object-fit: cover;
    }
    /* Make text justified */
    .card-body, 
    .tab-pane, 
    .list-unstyled li, 
    p, 
    div.col-sm-8 {
        text-align: justify;
    }
</style>

<div class="gtco-section border-bottom">
    <div class="gtco-container">
        <div class="row animate-box">
        @auth
                
            
            <div class="col-md-12 text-center gtco-heading">
                <h2>Welcome, {{ $user->full_name }}</h2>
            </div>
        </div>

        <div class="row">
            <!-- Left Column -->
            <div class="col-md-4" >
                <div class="card" style="padding: 30px;">
                    <div class="text-center p-3">
                        <img src="https://bootdey.com/img/Content/avatar/avatar7.png" class="rounded-circle profile-pic" alt="User photo">
                        <p class="mt-2 mb-0 text-muted"><a href="#"><i class="fas fa-camera"></i> Change Photo</a></p>
                    </div>
                    <hr>
                    <div class="px-3 pb-3">
                        <h6 class="text-muted">QUICK ACCESS</h6>
                        <ul class="list-unstyled">
                            <li><a href="#"><i class="fas fa-user-cog"></i> Account Management</a></li>
                            <li><a href="#"><i class="fas fa-id-card-alt"></i> Check License Status</a></li>
                            <li><a href="#"><i class="fas fa-download"></i> Download E-Driver’s License</a></li>
                            <li><a href="#"><i class="fas fa-bell"></i> Notifications</a></li>
                        </ul>

                        <h6 class="text-muted mt-4">USEFUL LINKS</h6>
                        <ul class="list-unstyled">
                            <li><a href="#"><i class="fas fa-question-circle"></i> Help & Support</a></li>
                            <li><a href="#"><i class="fas fa-book"></i> User Guide</a></li>
                            <li><a href="#"><i class="fas fa-envelope"></i> Contact Us</a></li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Right Column -->
            <div class="col-md-8">
                <div class="card">
                    <div class="card-body">
                       <div class="d-flex justify-content-between" style="padding:30px;">
                            <div>
                                <h4> {{ $user->full_name }}</h4>
                                <p class="text-primary">Citizen of Cambodia</p>
                            </div>
                            <button class="btn btn-outline-primary">
                                <i class="fas fa-edit"></i> Edit Profile
                            </button>
                        </div>
                        <p class="text-muted mb-1" style="padding: 10px;">Your Digital Driver's License Dashboard</p>
                        <hr style="margin: 10px;">


                        <ul class="nav nav-tabs" id="myTab" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" id="about-tab" data-toggle="tab" href="#about" role="tab">About</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="license-tab" data-toggle="tab" href="#license" role="tab">License Info</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="downloads-tab" data-toggle="tab" href="#downloads" role="tab">Downloads</a>
                            </li>
                        </ul>

                        <div class="tab-content pt-3"style="padding: 30px;">
                            <!-- About -->
                            <div class="tab-pane fade show active" id="about" role="tabpanel">
                                <div class="row">
                                    <div class="col-sm-4"><strong>User ID</strong></div>
                                    <div class="col-sm-8">{{ $user->id }}</div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-4"><strong>Full Name</strong></div>
                                    <div class="col-sm-8">{{ $user->full_name }}</div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-4"><strong>Gender</strong></div>
                                    <div class="col-sm-8">{{ $user->gender }}</div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-4"><strong>Email</strong></div>
                                    <div class="col-sm-8">{{ $user->email }}m</div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-4"><strong>Phone</strong></div>
                                    <div class="col-sm-8">{{ $user->phone }}</div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-4"><strong>Address</strong></div>
                                    <div class="col-sm-8">{{ $user->address }}</div>
                                </div>
                            </div>

                            <!-- License Info -->
                            <div class="tab-pane fade" id="license" role="tabpanel">
                                <div class="row">
                                    <div class="col-sm-4"><strong>License No.</strong></div>
                                    <div class="col-sm-8">KH-DL-998877</div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-4"><strong>Status</strong></div>
                                    <div class="col-sm-8"><span class="badge badge-success">Active</span></div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-4"><strong>Issued Date</strong></div>
                                    <div class="col-sm-8">2022-03-15</div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-4"><strong>Expiry Date</strong></div>
                                    <div class="col-sm-8">2027-03-14</div>
                                </div>
                            </div>

                            <!-- Downloads -->
                            <div class="tab-pane fade" id="downloads" role="tabpanel">
                                <p>Click below to download your digital documents:</p>
                                <a href="#" class="btn btn-success"><i class="fas fa-download"></i> E-Driver’s License</a>
                                <a href="#" class="btn btn-secondary ml-2"><i class="fas fa-print"></i> Print ID Card</a>
                            </div>
                        </div>
                        
                    </div>
                </div>
            </div>
            @endauth
        </div>
    </div>
</div>
@endsection
