<ul class="nav nav-tabs navtab-bg nav-justified">
    <li class="active">
        <a href="#home-2" data-toggle="tab" aria-expanded="true">
            <span class="hidden-xs">Basic Information</span>
        </a>
    </li>
    <li class="">
        <a href="#profile-2" data-toggle="tab" aria-expanded="false">
            <span class="visible-xs"><i class="fa fa-user"></i></span>
            <span class="hidden-xs">Bank Information</span>
        </a>
    </li>
    <li class="">
        <a href="#settings-2" data-toggle="tab" aria-expanded="false">
            <span class="visible-xs"><i class="fa fa-cog"></i></span>
            <span class="hidden-xs">Login Details & Documents</span>
        </a>
    </li>
</ul>
<div class="tab-content">
    <div class="tab-pane active" id="home-2">
        <div class="row">
            <div class="col-md-6">
                <div><label>Agency Name :</label> <?= $agency_details[0]['agency_name'] ?></div>
                <div><label>Contact Name :</label> <?= $agency_details[0]['contact_name'] ?></div>
                <div><label>Agency Email :</label> <?= $agency_details[0]['agency_email'] ?></div>
                <div><label>Agency Phone Number :</label> <?= $agency_details[0]['agency_phone'] ?></div>
                <div><label>Agency Address :</label> <?= $agency_details[0]['agency_address'] ?></div>
                <?php if ($agency_details[0]['agency_sub_address'] != ""): ?>
                    <div><label>Agency Unit, Building, Etc :</label> <?= $agency_details[0]['agency_sub_address'] ?></div>
                <?php endif; ?>
            </div>
            <div class="col-md-6">
                <div><label>State :</label> <?= $agency_details[0]['agency_state'] ?></div>
                <div><label>Address Addtional :</label> <?= $agency_details[0]['agency_city'] ?></div>
                <div><label>Zipcode :</label> <?= $agency_details[0]['agency_zip_code'] ?></div>
                <div><label>Customer Service Number :</label> <?= $agency_details[0]['agency_customer_service_number'] ?></div>
                <div><label>Customer Service Email :</label> <?= $agency_details[0]['agency_customer_service_email'] ?></div>
            </div>
        </div>
    </div>
    <div class="tab-pane" id="profile-2">
        <div class="row">
            <div class="col-md-6">
                <div><label>Bank Name :</label> <?= $agency_details[0]['bank_name'] ?></div>
                <div><label>Bank Address :</label> <?= $agency_details[0]['bank_add'] ?></div>
                <div><label>Bank City :</label> <?= $agency_details[0]['bank_city'] ?></div>
                <div><label>Bank State :</label> <?= $agency_details[0]['bank_state'] ?></div>
                <div><label>Bank Zipcode :</label> <?= $agency_details[0]['bank_zipcode'] ?></div>
            </div>
            <div class="col-md-6">
                <div><label>Name On Account : </label> <?= $agency_details[0]['agency_name_on_account'] ?></div>
                <div><label>Agency Account Number : </label> <?= $agency_details[0]['agency_account_number'] ?></div>
                <div><label>Angecy Routing Number :</label> <?= $agency_details[0]['angecy_routing_number'] ?></div>
            </div>
        </div>
    </div>
    <div class="tab-pane" id="settings-2">
        <div class="row">
            <div class="row">
                <div class="col-md-4">
                    <div class="first-logo-div"><label>Agency Logo : </label><img src="<?= base_url() ?>assets/crm_image/agencieslogo/<?= $agency_details[0]['agency_image'] ?>"></div>
                </div>
                <div class="col-md-4">
                    <div class="logo-div-content"><label>Agency Domain : </label><?= $agency_details[0]['agency_domain'] ?></div>
                    <div><label>Login Email : </label><?= $agency_details[0]['email'] ?></div>
                    <div><label>Created Date : </label><?= $agency_details[0]['created_date'] ?></div>
                </div>
                <div class="col-md-4 logo-div-content-second">
                    <div><label><a href="<?= base_url() ?>assets/crm_docs/agency_uploaded_docs/<?= $agency_details[0]['agency_w9_form'] ?>"><span>Download/View W9 Form</span><i class="fa fa-download"></i></a></label></div>
                    <div><label><a href="<?= base_url() ?>assets/crm_docs/agency_uploaded_docs/<?= $agency_details[0]['agency_direct_deposit'] ?>"><span>Download/View Direct Deposit Form <i class="fa fa-download"></i></span></a></label></div>
                    <div><label><a href="<?= base_url() ?>assets/crm_docs/agency_uploaded_docs/<?= $agency_details[0]['agency_contract_agreement'] ?>"><span>Download/View Contract Agreement Form <i class="fa fa-download"></i></span></a></label></div>
                </div>
            </div>
        </div>
    </div>
</div>