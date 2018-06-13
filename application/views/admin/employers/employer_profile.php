
<ul class="nav nav-tabs navtab-bg nav-justified">
    <li class="active">
        <a href="#home-2" data-toggle="tab" aria-expanded="true">
            <span class="hidden-xs">EMPLOYER</span>
        </a>
    </li>
    <li class="">
        <a href="#profile-2" data-toggle="tab" aria-expanded="false">
            <span class="visible-xs"><i class="fa fa-user"></i></span>
            <span class="hidden-xs">DAILY</span>
        </a>
    </li>
    <li class="">
        <a href="#messages-2" data-toggle="tab" aria-expanded="false">
            <span class="visible-xs"><i class="fa fa-envelope-o"></i></span>
            <span class="hidden-xs">BILLING</span>
        </a>
    </li>
    <li class="">
        <a href="#messages-3" data-toggle="tab" aria-expanded="false">
            <span class="visible-xs"><i class="fa fa-envelope-o"></i></span>
            <span class="hidden-xs">TECHNICAL</span>
        </a>
    </li>
    <li class="">
        <a href="#messages-4" data-toggle="tab" aria-expanded="false">
            <span class="visible-xs"><i class="fa fa-envelope-o"></i></span>
            <span class="hidden-xs">FULFILLMENT</span>
        </a>
    </li>
    <li class="">
        <a href="#settings-2" data-toggle="tab" aria-expanded="false">
            <span class="visible-xs"><i class="fa fa-cog"></i></span>
            <span class="hidden-xs">LOGIN</span>
        </a>
    </li>
</ul>
<div class="tab-content">
    <div class="tab-pane active" id="home-2">
        <div class="row">
            <div class="col-md-6">
                <div><label>Employer Name : </label> <?= $emp_details[0]['employer_name'] ?></div>
                <div><label>Website  : </label> <?= $emp_details[0]['employer_website'] ?></div>
                <div><label>Email Address : </label> <?= $emp_details[0]['employer_email'] ?></div>
                <div><label>Customer Service Number : </label> <?= $emp_details[0]['employer_cus_service_number'] ?></div>
                <div><label>Fax Number : </label> <?= $emp_details[0]['employer_fax'] ?></div>
            </div>
            <div class="col-md-6">
                <div><label>Address : </label> <?= $emp_details[0]['employer_address'] ?></div>
                <div><label>Apartment, Suite, etc : </label> <?= $emp_details[0]['employer_address_details'] ?></div>
                <div><label>City : </label> <?= $emp_details[0]['employer_city'] ?></div>
                <div><label>State : <label> <?= $emp_details[0]['state'] ?></div>
                <div><label>Zipcode : </label> <?= $emp_details[0]['employer_zipcode'] ?></div>
            </div>
        </div>
    </div>
    <div class="tab-pane" id="profile-2">
        <div class="row">
            <div class="col-md-6">
                <div><label>First Name : </label> <?= $emp_details[0]['daily_contact_firstname'] ?></div>
                <div><label>Last Name : </label> <?= $emp_details[0]['daily_contact_lastname'] ?></div>
                <div><label>Title : </label> <?= $emp_details[0]['daily_contact_title'] ?></div>
            </div>
            <div class="col-md-6">
                <div><label>Email Address : </label> <?= $emp_details[0]['daily_contact_email'] ?></div>
                <div><label>Phone Number : </label> <?= $emp_details[0]['daily_contact_contact_number'] ?></div>
                <div><label>Extension : </label> <?= $emp_details[0]['daily_contact_extension'] ?></div>
            </div>
        </div>
    </div>
    <div class="tab-pane" id="messages-2">
         <div class="row">
            <div class="col-md-6">
                <div><label>First Name : </label> <?= $emp_details[0]['billing_contact_firstname'] ?></div>
                <div><label>Last Name : </label> <?= $emp_details[0]['billing_contact_lastname'] ?></div>
                <div><label>Title : </label> <?= $emp_details[0]['billing_contact_title'] ?></div>
            </div>
            <div class="col-md-6">
                <div><label>Email Address : </label> <?= $emp_details[0]['billing_contact_email'] ?></div>
                <div><label>Phone Number : </label> <?= $emp_details[0]['billing_contact_contact_number'] ?></div>
                <div><label>Extension : </label> <?= $emp_details[0]['billing_contact_extension'] ?></div>
            </div>
        </div>
    </div>
     <div class="tab-pane" id="messages-3">
         <div class="row">
            <div class="col-md-6">
                <div><label>First Name : </label> <?= $emp_details[0]['technical_contact_firstname'] ?></div>
                <div><label>Last Name : </label> <?= $emp_details[0]['technical_contact_lastname'] ?></div>
                <div><label>Title : </label> <?= $emp_details[0]['technical_contact_title'] ?></div>
            </div>
            <div class="col-md-6">
                <div><label>Email Address : </label> <?= $emp_details[0]['technical_contact_email'] ?></div>
                <div><label>Phone Number : </label> <?= $emp_details[0]['technical_contact_contact_number'] ?></div>
                <div><label>Extension : </label> <?= $emp_details[0]['technical_contact_extension'] ?></div>
            </div>
        </div>
    </div>
     <div class="tab-pane" id="messages-4">
         <div class="row">
            <div class="col-md-6">
                <div><label>Fulfillment : </label> <?php echo  ($emp_details[0]['employer_fulfillment'] == 'e_fulfillment')? 'E-Fulfillment':'Hard Fulfillment ($5.00 per member)';?>


                </div>
            </div>
           
        </div>
    </div>
    <div class="tab-pane" id="settings-2">
        <div class="row">
            <div class="col-md-8">
                <div><label>Login Email Address : </label> <?= $emp_details[0]['email'] ?></div>
                <div><label>Registration Date : </label> <?= $emp_details[0]['created_date'] ?></div>
            </div>
        </div>
    </div>
</div>