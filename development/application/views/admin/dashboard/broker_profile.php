<ul class="nav nav-tabs navtab-bg nav-justified">
    <li class="active">
        <a href="#home-2" data-toggle="tab" aria-expanded="true">
            <span class="hidden-xs">Personal Information</span>
        </a>
    </li>
    <li class="">
        <a href="#profile-2" data-toggle="tab" aria-expanded="false">
            <span class="visible-xs"><i class="fa fa-user"></i></span>
            <span class="hidden-xs">Business Information</span>
        </a>
    </li>
    <li class="">
        <a href="#messages-2" data-toggle="tab" aria-expanded="false">
            <span class="visible-xs"><i class="fa fa-envelope-o"></i></span>
            <span class="hidden-xs">Commision Information</span>
        </a>
    </li>
    <li class="">
        <a href="#settings-2" data-toggle="tab" aria-expanded="false">
            <span class="visible-xs"><i class="fa fa-cog"></i></span>
            <span class="hidden-xs">Login Details</span>
        </a>
    </li>
</ul>

<div class="tab-content">
    <div class="tab-pane active" id="home-2">
        <div class="row">
            <div class="col-md-6">
                <div><label>First Name :</label> <?= $broker_details[0]['first_name'] ?></div>
                <div><label>Middle Name :</label> <?= $broker_details[0]['middle_name'] ?></div>
                <div><label>Last Name :</label> <?= $broker_details[0]['last_name'] ?></div>
                <div><label>Email Address :</label> <?= $broker_details[0]['personal_email_address'] ?></div>
                <div><label>Phone Number :</label> <?= $broker_details[0]['personal_phone_number'] ?></div>
                <div><label>DOB :</label> <?= $broker_details[0]['dob'] ?></div>
            </div>
            <div class="col-md-6">
                <div><label>Address :</label> <?= $broker_details[0]['personal_address'] ?></div>
                <div><label>Address Addtional :</label> <?= $broker_details[0]['personal_address_addtional'] ?></div>
                <div><label>City :</label> <?= $broker_details[0]['personal_city'] ?></div>
                <div><label>State :<label> <?= $broker_details[0]['personal_state'] ?></div>
                <div><label>Zipcode :</label> <?= $broker_details[0]['personal_zipcode'] ?></div>
            </div>
        </div>
    </div>
    <div class="tab-pane" id="profile-2">
        <div class="row">
            <div class="col-md-6">
                <div><label>Legal bussiness name :</label> <?= $broker_details[0]['legal_bussiness_name'] ?></div>
                <div><label>Business email address :</label> <?= $broker_details[0]['business_email_address'] ?></div>
                <div><label>Custom service name :</label> <?= $broker_details[0]['custom_service_name'] ?></div>
                <div><label>Business fax number :</label> <?= $broker_details[0]['business_fax_number'] ?></div>
            </div>
            <div class="col-md-6">
                <div><label>Business address : </label> <?= $broker_details[0]['business_address'] ?></div>
                <div><label>Business add addtional : </label> <?= $broker_details[0]['business_add_addtional'] ?></div>
                <div><label>Business city :</label> <?= $broker_details[0]['business_city'] ?></div>
                <div><label>Business state :</label> <?= $broker_details[0]['business_state'] ?></div>
                <div><label>Business zip code :</label> <?= $broker_details[0]['business_zip_code'] ?></div>
            </div>
        </div>
    </div>
    <div class="tab-pane" id="messages-2">
        <div class="row">
            <div class="col-md-6">
                <div><label>Commision Pay to :</label> <?php echo ($broker_details[0]['commision_payto'] == "my_business") ? 'My Business' : 'My Self'; ?></div> 
                <div><label><?php echo ($broker_details[0]['commision_payto'] == "my_business") ? 'My Business' : 'My Self'; ?></label><?php echo ($broker_details[0]['commision_payto'] == 'my_business' ? $broker_details[0]['federal_tax_id'] : $broker_details[0]['social_security_number']); ?></div> 
                <div><label>Commsion Receive Type :</label> <?php echo ($broker_details[0]['commsion_receive'] == 'Paper_Check') ? 'Paper Check' : 'Direct Deposit'; ?></div> 
                <div><label>Name Of Account :</label> <?= $broker_details[0]['commision_name_on_account'] ?></div>
                <?php echo($broker_details[0]['commsion_receive'] == 'Direct_Deposit') ? '<div><label>Name Of Account</label>' . $broker_details[0]['commision_bank_name'] . '</div>' : ''; ?> 
            </div>
            <div class="col-md-6">
                <div><label>Address :</label> <?= $broker_details[0]['commision_address'] ?></div>
                <div><label> Unit,Suite,ect. :</label> <?= $broker_details[0]['commision_add_addtional'] ?></div>
                <div><label>City :</label> <?= $broker_details[0]['commision_city'] ?></div>
                <div><label>State :</label> <?= $broker_details[0]['commision_state'] ?></div>
                <div><label>Zipcode :</label> <?= $broker_details[0]['commision_zipcode'] ?></div>
                <?php if ($broker_details[0]['commsion_receive'] == 'Direct_Deposit'): ?>
                    <div><label>Account Type :</label> <?php echo($broker_details[0]['account_options'] == "checking") ? 'Checking Account' : 'Saving Account'; ?></div>
                    <div><label>Rounting Number :</label> <?= $broker_details[0]['rounting_number'] ?></div>
                    <div><label>Account Number :</label> <?= $broker_details[0]['account_number'] ?></div>
                    <div><label>Upload void Check :</label> <?= $broker_details[0]['upload_void_check'] ?></div>
                <?php endif; ?>
            </div>
        </div>
    </div>
    <div class="tab-pane" id="settings-2">
        <div class="row">
            <div class="col-md-8">
                <div><label>Login Email Address : </label> <?= $broker_details[0]['email'] ?></div>
                <div><label>Registration Date : </label> <?= $broker_details[0]['created_date'] ?></div>
            </div>
        </div>
    </div>
</div>