@extends('includes.body-admin')

@section('content')

    <!-- business body content -->
    <section class="businees-pro-cre">
        <div class="container">
            <h2 class="busi-p-cre-head text-black">Create your business profile</h2>
            <div class="row">
                <form action="" class="user-data">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="data-input-label text-black" for="exampleInputEmail1">Business Name</label>
                            <span class="input-detail text-gray-3">Name of company, DBA or sole proprietorship.</span>
                            <input type="text" class="form-control" id="exampleInputEmail1" placeholder="">
                        </div>
                        <div class="form-group">
                            <label class="data-input-label text-black" for="exampleInputEmail1">Business Tax ID</label>
                            <span class="input-detail text-gray-3">Please enter business EIN, Tax ID or sole proprietor social security number.</span>
                            <input type="text" class="form-control" id="exampleInputEmail1" placeholder="">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="image-uploader">
                            <img class="up-img up-img-1" src="{{asset('images/uplaod-icon.png')}}" alt="">
                            <span class="up-img up-text">Add Profile Picture</span>
                        </div>

                        <div class="clearfix"></div>
                        <!-- upload file -->
                        <input id="upload" type="file"/>
                        <a href="" id="upload_link">
                            <div class="img-upload">
                                <img class="up-plus" src="{{asset('images/up-plus.png')}}" alt="">
                            </div>
                        </a>

                    </div>
                    <div class="clearfix"></div>
                    <div class="col-md-12">
                        <div class="row">
                            <div class="col-md-12">
                                <label class="data-input-label text-black b-addr" for="exampleInputEmail1">Business Address</label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <span class="input-detail text-gray-3">Street Address</span>
                                    <input type="text" class="form-control" id="exampleInputEmail1" placeholder="">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <span class="input-detail text-gray-3">Address Line 2   </span>
                                    <input type="text" class="form-control" id="exampleInputEmail1" placeholder="">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <span class="input-detail text-gray-3">City </span>
                                    <input type="text" class="form-control" id="exampleInputEmail1" placeholder="">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <span class="input-detail text-gray-3">Province/State* </span>
                                            <input type="text" class="form-control" id="exampleInputEmail1" placeholder="">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <span class="input-detail text-gray-3">Postcode/Zip* </span>
                                            <input type="text" class="form-control" id="exampleInputEmail1" placeholder="">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="clearfix"></div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="data-input-label text-black mgr-b" for="exampleInputEmail1">Primary Contact First Name</label>
                                    <input type="text" class="form-control" id="exampleInputEmail1" placeholder="">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="data-input-label text-black mgr-b" for="exampleInputEmail1">Primary Contact Last Name</label>
                                    <input type="text" class="form-control" id="exampleInputEmail1" placeholder="">
                                </div>
                            </div>

                            <div class="clearfix"></div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="data-input-label text-black mgr-b" for="exampleInputEmail1">Primary Contact Phone Number</label>
                                    <input type="text" class="form-control" id="exampleInputEmail1" placeholder="">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="data-input-label text-black mgr-b" for="exampleInputEmail1"> Primary Contact Email Address</label>
                                    <input type="email" class="form-control" id="exampleInputEmail1" placeholder="">
                                </div>
                            </div>
                            <div class="clearfix"></div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <p class="isBilling text-gray-3">Is the primary contact also the billing contact?</p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group rdo1">
                                    <input class="check" type="radio" name="status"><span class="text-gray-3">Yes</span>
                                    <input class="check" type="radio" name="status"><span class="text-gray-3">No</span>
                                </div>
                            </div>
                            <div class="clearfix"></div>

                            <div class="col-md-12">
                                <h3 class="payMetod text-black">Select payment method</h3>
                                <ul class="checkPayMethod">
                                    <li>
                                        <input class="check" type="checkbox"><span class="text-gray-3">ACH</span>
                                    </li>
                                    <li>
                                        <input class="check" type="checkbox"><span class="text-gray-3">Debit Card</span>
                                    </li>
                                    <li>
                                        <input class="check" type="checkbox"><span class="text-gray-3">Credit Card</span>
                                    </li>
                                    <li>
                                        <input class="check" type="checkbox"><span class="text-gray-3">Invoice</span>
                                    </li>
                                    <li>
                                        <input class="check" type="checkbox"><span class="text-gray-3">Check</span>
                                    </li>
                                </ul>
                                <button type="submit" class="btn btn-primary btn-submit bg-red text-white btn-regis btn-save">save</button>
                            </div>

                        </div>
                    </div>
                </form>
            </div>
        </div>
    </section>
    <div class="push"></div>
    </div>
    <!-- business body content end-->


@endsection
