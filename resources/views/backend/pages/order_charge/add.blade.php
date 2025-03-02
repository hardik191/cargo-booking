<div class="row g-3 g-xl-3 ">
    <div class="col-md-12">
        <label class="fs-6 fw-semibold form-label mb-2">
            <span class="required">Charge Name</span>
        </label>
         <input type="text" class="form-control form-control-lg" autocomplete="off" name="charge_name" placeholder="Please enter charge name"/>
    </div>

    <div class="col-md-12">
        <label class="fs-6 fw-semibold form-label mb-2">
            <span class="required">Charge Value</span>
        </label>
         <input type="text" class="form-control form-control-lg charge_value onlyDigit" autocomplete="off" name="charge_value" placeholder="Please enter charge value"/>
    </div>

    <div class="col-md-12">
        <label class="fs-6 fw-semibold form-label mb-2">
            <span class="required">Charge Type</span>
        </label>

        <select name="charge_type" id="charge_type" class="form-select select3" data-control="select2" data-dropdown-parent="#add_order_charge_modal" data-placeholder="Select charge type" data-hide-search="true" data-allow-clear="true"  >
            <option></option>
            @foreach($charge_type as $key => $type)
                <option value="{{ $key }}">{{ $type }}</option>
            @endforeach
        </select>
    </div>

    <div class="col-md-12">
        <label class="fs-6 fw-semibold form-label mb-2">
            <span class="">Status</span>
        </label>
        <div class="form-check-custom form-check-radio-custom d-flex flex-wrap">
            <span class="form-check form-check-custom form-check-solid form-check-success d-flex align-items-center me-4 mb-2">
                <input type="radio" name="status" id="active" class="form-check-input" value="1" checked>
                <label for="active" class="ms-2 fs-6">Active</label>
            </span>
            <span class="form-check form-check-custom form-check-solid form-check-danger d-flex align-items-center mb-2">
                <input type="radio" name="status" id="inactive" class="form-check-input" value="2" >
                <label for="inactive" class="ms-2 fs-6">Inactive</label>
            </span>
        </div>
    </div>
</div>
