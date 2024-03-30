@extends('layouts.app')
@section('title')
    - Settings
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <!-- Tab links -->
                <div class="tab">
                    <button class="tablinks general_settings active">Store Details</button>
                    <button class="tablinks discounts">Discounts</button>
                    <button class="tablinks user_accounts">User Accounts</button>
                    <button class="tablinks my_profile">My Profile</button>
                </div>
                <hr>

                <!-- Tab contents -->
                <!-- General Settings Tab contents -->
                <div class="tabcontent" id="general_settings" style="display: block;">
                    <div class="row">
                        <div class="col-md-4 p-3" style="border-right:1px solid #ccc; height:78vh;" id="store_display">
                            <div class="card-info p-3">
                                @foreach ($store_info as $info)
                                <div class="logodisplay mb-2"  style="margin:auto; background-image: url('public_uploads/{{$info->logo}}')" ></div>
                                <span>
                                    <i class="fa-solid fa-building-columns"></i> {{$info->store_name}}
                                </span><div class="divider"></div>
                                <span>
                                    <i class="fa-solid fa-fire"></i> {{$info->slogan}}
                                </span><div class="divider"></div>
                                <span>
                                    <i class="fa-solid fa-location-dot"></i> {{$info->address}}
                                </span><div class="divider"></div>
                                <span>
                                    <i class="fa-solid fa-square-phone"></i> {{$info->telephone}}
                                </span><div class="divider"></div>
                                <span>
                                    <i class="fa-solid fa-envelope"></i> {{$info->email}}
                                </span><div class="divider"></div>
                                <button class="edit_storebtn">
                                    <i class="fa-solid fa-pen-to-square text-primary"></i>
                                </button>
                                @endforeach
                            </div>
                        </div>
                        <div class="col-md-5 p-2" >
                            <div id="store_info" style="display:none; border-right:1px solid #ccc; height:78vh;" class="p-2">
                            <h6 class="fw-bold">Update Store Details</h6>
                            <hr>
                            <form action="#" method="post" id="store_info_form" data-parsley-validate="">
                            <div class="d-flex flex-column justify-content-center align-items-center">
                                <div class="input-group mt-2 mb-3">
                                    <span class="input-group-text">Name <span class="text-danger">*</span></span>
                                    <input type="text" name="store_name" id="store_name" value="{{$info->store_name}}"
                                        class="form-control prod-input" placeholder="Name" autofocus required>
                                </div>
                                <div class="input-group mb-3">
                                    <span class="input-group-text">Slogan <small
                                            class="text-primary">(Optional)</small></span>
                                    <input type="text" name="slogan" id="slogan" value="{{$info->slogan}}"
                                        class="form-control prod-input" placeholder="Slogan">
                                </div>
                                <div class="input-group mb-3">
                                    <span class="input-group-text">Address <small
                                            class="text-primary">(Optional)</small></span>
                                    <input type="text" name="address" id="address" value="{{$info->address}}"
                                        class="form-control prod-input " placeholder="Address" required>
                                </div>
                                <div class="input-group mb-3">
                                    <span class="input-group-text">Telephone <small
                                            class="text-primary">(Optional)</small></span>
                                    <input type="text" name="telephone" id="telephone" value="{{$info->telephone}}"
                                        pattern="[0-9]{4}-[0-9]{3}-[0-9]{3}" class="form-control prod-input "
                                        placeholder="07xx-xxx-xxx" required>
                                </div>
                                <div class="input-group mb-3">
                                    <span class="input-group-text">Email <small
                                            class="text-primary">(Optional)</small></span>
                                    <input type="email" name="email" id="email" value="{{$info->email}}"
                                        class="form-control prod-input" placeholder="abc@example.com">
                                </div>
                                <div class="d-flex flex-row justify-content-between align-items-center mb-3">
                                    <div id="logo_display" class="image_display"
                                        style="width:8em; height:5em; background-image: url('public_uploads/{{$info->logo}}')" ></div>
                                    <input type="file" name="logo" id="logo" class="form-control mt-3 image"
                                        accept="image/png, image/jpeg">
                                </div>
                                <button type="submit" class="btn btn-primary w-75" >Update <i class="fa-solid fa-arrows-spin"></i></button>
                            </div>
                        </form>
                        </div>
                        </div>

                        

                    </div>

                </div>
                <!--- Discounts Tab contents  -->
                <div class="tabcontent" id="discounts" style="display: none;">
                    <div class="row">
                        <div class="col-md-6" style="border-right:1px solid #ccc; height:78vh;">
                            <div id="discounts_list">
                               
                               
                                 <div class="d-flex flex-row justify-content-start align-items-center flex-wrap disc_list">
                                    <div class="btn btn-primary m-2" id="new_discount">New Discount</div>
                                     @if (count($discounts)>0)
                                        @foreach ($discounts as $discount)
                                            <div class="card-discount m-2">
                                                <div class="d-flex flex-row align-items-end justify-content-end">
                                                    <button class="edit_discount"><i
                                                            class="fa-regular fa-pen-to-square"></i>
                                                    </button>
                                                </div>
                                                @if ($discount->status==true)
                                                <span class="disc_status text-success"><i class="fa-solid fa-circle"></i> Active</span>
                                                @else
                                                <span class="disc_status text-danger"><i class="fa-solid fa-circle"></i> Inactive</span>
                                                @endif
                                                
                                                <span class="disc_id d-none">{{ $discount->code }}</span>
                                                <span class="disc_title">{{ $discount->title }}</span>
                                                <h3 class="disc_rate">{{ $discount->rate }}% Off</h3>
                                            </div>
                                        @endforeach
                                    @else
                                    <h5 class="text-danger">No discount records found</h5>
                                    @endif
                                </div>
                                
                            </div>
                        </div>
                        <div class="col-md-6" id="discounts_section" style="display: none">
                            <div class="row justify-content-center">
                                <h6 class="fw-bold disc_action_type">Manage Discount</h6> <hr>
                                <div class="col-md-8">                                    
                                    <form action="#" method="post" id="discounts_form" data-parsley-validate>
                                        <div class="d-flex flex-column">
                                            <div class="input-group mb-3">
                                                <span class="input-group-text">Code <span
                                                        class="text-danger">*</span></span>
                                                <input type="text" name="discount_code" id="discount_code"
                                                    class="form-control prod-input" placeholder="e.g. 1234F"
                                                    required>
                                            </div>

                                            <div class="input-group mb-3">
                                                <span class="input-group-text">Title <span
                                                        class="text-danger">*</span></span>
                                                <input type="text" name="discount_title" id="discount_title"
                                                    class="form-control prod-input" placeholder="e.g. Easter Sale 5% Off"
                                                    required>
                                            </div>
                                            <div class="input-group mb-3">
                                                <span class="input-group-text">Rate % <span
                                                        class="text-danger">*</span></span>
                                                <input type="number" name="discount_rate" id="discount_rate"
                                                    class="form-control prod-input " placeholder="0.00" required
                                                    step=".01" min='0'>
                                            </div>

                                            <span>Status </span>
                                            <div class="btn-group " role="group"
                                                aria-label="Vertical radio toggle button group">
                                                <input type="radio" class="btn-check" name="vbtn-radio"
                                                    id="vbtn-radio1" autocomplete="off" value="1">
                                                <label class="btn btn-outline-success" for="vbtn-radio1">On</label>

                                                <input type="radio" class="btn-check" name="vbtn-radio"
                                                    id="vbtn-radio3" autocomplete="off" checked="" value="0">
                                                <label class="btn btn-outline-danger" for="vbtn-radio3">Off</label>
                                            </div>

                                            <div class="d-flex justify-content-center align-items-center mt-3">
                                                <button type="submit" class="btn btn-primary w-25 m-2 p-2"
                                                    id="savediscountbtn">
                                                    Save <i class="fa-regular fa-floppy-disk"></i>
                                                </button>
                                                <button type="button" class="btn btn-danger w-25 m-2 p-2"
                                                    id="deletediscountbtn">
                                                    Delete <i class="fa-solid fa-trash"></i>
                                                </button>
                                               
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


                <!-- User Accounts Tab contents -->
                <div class="tabcontent" id="user_accounts" style="display: none;">
                    <div class="row">
                        <div class="col-md-6" style="border-right: 1px solid #ccc; height:75vh;">
                            <div class="input-group mt-3 mb-3">
                                <span class="input-group-text">Search User</span>
                                <input type="search" name="search_user" id="search_user"
                                    class="form-control prod-input" placeholder="Search by name">
                            </div>
                            <div class="d-flex flex-row flex-wrap justify-content-start align-items-center users_list">
                                <div class="card-template m-2 p-2">
                                    
                                    <div class="user_icon">
                                        <i class="fa-solid fa-user-plus"></i>
                                    </div>
                                    <h6 class="user_name">New User</h6>
                                   
                                </div>
                            @foreach ($users as $user)
                                <div class="card-template m-2 p-2">
                                    <button class="edit_btn">
                                        <i class="fa-solid fa-pen-to-square"></i>
                                    </button>
                                    <div class="user_icon">
                                        <i class="fa-solid fa-user-tie"></i>
                                    </div>
                                    <h6 class="user_name">{{$user->name}}</h6>
                                    <span>{{$user->role}}</span>
                                </div>
                            @endforeach
                        </div>
                        </div>
                        <div class="col-md-6" >
                            <div class="manage_user" style="display:none;">
                            <h6 class="fw-bold">Manage User Account</h6><hr>
                            <div class="d-flex flex-column" style="padding-left: 3em; padding-right:3em;">
                                <form id="user_form" action="#" method="post" data-parsley-validate="">
                                    <div class="input-group mt-3 mb-3">
                                        <span class="input-group-text">Name <span class="text-danger">*</span></span>
                                        <input type="text" name="name" id="name"
                                            class="form-control prod-input " placeholder="John Doe">
                                    </div>
                                    <div class="input-group mt-3 mb-3">
                                        <span class="input-group-text">Email <span class="text-danger">*</span></span>
                                        <input type="email" name="email" id="email"
                                            class="form-control prod-input " placeholder="user@example.com">
                                    </div>
                                    <div class="input-group mt-3 mb-3">
                                        <span class="input-group-text">Password <span class="text-danger">*</span></span>
                                        <input type="text" name="password" id="password"
                                            class="form-control prod-input " placeholder="Password">
                                    </div>
                                    <div class="input-group mt-3 mb-3">
                                        <span class="input-group-text">Role <span class="text-danger">*</span></span>
                                        <select name="role" id="role" class="form-select">
                                            <option value="">Select Role</option>
                                            <option value="Cashier">Cashier</option>
                                            <option value="Admin">Cashier</option>
                                        </select>
                                    </div>
                                    <div class="d-flex flex-row justify-content-center">
                                        <button class="btn btn-primary m-2 p-2 w-25">Save <i class="fa-regular fa-floppy-disk"></i></button>
                                        <button class="btn btn-danger m-2 p-2 w-25">Delete <i class="fa-solid fa-user-xmark"></i></button>
                                    </div>
                                </form>
                            </div>
                        </div>
                        </div>
                    </div>
                </div>

                <!-- User Accounts Tab contents -->
                <div class="tabcontent" id="my_profile" style="display: none;"></div>

            </div>
        </div>
    </div>
@endsection
