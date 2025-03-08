<div class="row g-5 g-xl-4 ">
    <div class="col-md-12">
        <label class="fs-6 fw-semibold form-label mb-2">
            <span class="required">Container Type</span>
        </label>
        <input type="text" class="form-control form-control-lg container_type" autocomplete="off" name="container_type" value="{{ $container_details->container_type }}" placeholder="Please enter container type"/>
    </div>
    <input type="hidden" name="edit_id" value="{{ $container_details->id }}">

    {{-- <div class="col-md-12">
        <label class="fs-6 fw-semibold form-label mb-2">
            <span class="required">Maximum Container</span>
        </label>
        <input type="text" class="form-control form-control-lg max_container onlyNumber" autocomplete="off" name="max_container" value="{{ $container_details->max_container }}" placeholder="Please enter maximum container"/>
    </div> --}}

    <div class="col-md-6">
        <label class="fs-6 fw-semibold form-label mb-2">
            <span class="required">Maximum Capacity</span>
        </label>
        <input type="text" class="form-control form-control-lg max_capacity onlyDigit" autocomplete="off" name="max_capacity" value="{{ $container_details->max_capacity }}" placeholder="Please enter maximum capacity"/>
    </div>

    <div class="col-md-6">
        <label class="fs-6 fw-semibold form-label mb-2">
            <span class="">Capacity Unit</span>
        </label>
        <div class="form-check-custom form-check-radio-custom d-flex flex-wrap">
            <span class="form-check form-check-custom form-check-solid form-check-info d-flex align-items-center me-4 mb-2">
                <input type="radio" name="capacity_unit" id="edit_kg" class="form-check-input" value="1" {{ $container_details->capacity_unit == 1 ? 'checked' : '' }}>
                <label for="edit_kg" class="ms-2 fs-6">KG</label>
            </span>
            <span class="form-check form-check-custom form-check-solid form-check-info d-flex align-items-center mb-2">
                <input type="radio" name="capacity_unit" id="edit_tons" class="form-check-input" value="2" {{ $container_details->capacity_unit == 2 ? 'checked' : '' }}>
                <label for="edit_tons" class="ms-2 fs-6">Tons</label>
            </span>
        </div>
    </div>

    <div class="col-md-12">
        <label class="fs-6 fw-semibold form-label mb-2">
            <span class="required">Base Price</span>
        </label>
        <input type="text" class="form-control form-control-lg base_price onlyDigit" autocomplete="off" name="base_price" value="{{ $container_details->base_price }}" placeholder="Please enter base price"/>
    </div>

    <div class="col-md-12">
        <label class="fs-6 fw-semibold form-label mb-2">
            <span class="">Status</span>
        </label>
        <div class="form-check-custom form-check-radio-custom d-flex flex-wrap">
            <span class="form-check form-check-custom form-check-solid form-check-success d-flex align-items-center me-4 mb-2">
                <input type="radio" name="status" id="edit_active" class="form-check-input" value="1" {{ $container_details->status == 1 ? 'checked' : '' }}>
                <label for="edit_active" class="ms-2 fs-6">Active</label>
            </span>
            <span class="form-check form-check-custom form-check-solid form-check-danger d-flex align-items-center mb-2">
                <input type="radio" name="status" id="edit_inactive" class="form-check-input" value="2" {{ $container_details->status == 2 ? 'checked' : '' }}>
                <label for="edit_inactive" class="ms-2 fs-6">Inactive</label>
            </span>
        </div>
    </div>
</div>
