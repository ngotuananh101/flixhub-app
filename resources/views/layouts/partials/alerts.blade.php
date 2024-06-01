@session('success')
<div
    class="alert alert-dismissible bg-light-success border border-success border-dashed
                                    d-flex flex-column flex-sm-row w-100 p-5">
    <div class="d-flex flex-column pe-0 pe-sm-10">
        <h5 class="mb-1">Success:</h5>
        <span>{{ session('success') }}</span>
    </div>
    <button type="button"
            class="position-absolute position-sm-relative m-2 m-sm-0 top-0 end-0 btn
                                                btn-icon ms-sm-auto"
            data-bs-dismiss="alert">
        <i class="ki-duotone ki-cross fs-1 text-success">
            <span class="path1"></span>
            <span class="path2"></span>
        </i>
    </button>
</div>
@endsession
@session('error')
<div
    class="alert alert-dismissible bg-light-danger border border-danger border-dashed
                                    d-flex flex-column flex-sm-row w-100 p-5">
    <div class="d-flex flex-column pe-0 pe-sm-10">
        <h5 class="mb-1">Error:</h5>
        <span>{{ session('error') }}</span>
    </div>
    <button type="button"
            class="position-absolute position-sm-relative m-2 m-sm-0 top-0 end-0 btn
                                                btn-icon ms-sm-auto"
            data-bs-dismiss="alert">
        <i class="ki-duotone ki-cross fs-1 text-danger">
            <span class="path1"></span>
            <span class="path2"></span>
        </i>
    </button>
</div>
@endsession
