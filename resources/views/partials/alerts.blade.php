<!-- start general alerts -->
<!-- success -->
@if (Session::has('success'))
    <div class="alert alert-success d-flex align-items-center alert-dismissible fade show" role="alert">
        <i class="fa-solid fa-circle-check"></i>
        <div class="ms-2">
            {{ Session::get('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    </div>
@endif
<!-- warning -->
@if (Session::has('warning'))
    <div class="alert alert-warning d-flex align-items-center alert-dismissible fade show" role="alert">
        <i class="fa-solid fa-triangle-exclamation"></i>
        <div class="ms-2">
            {{ Session::get('warning') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    </div>
@endif
<!-- failure -->
@if (Session::has('failure'))
    <div class="alert alert-danger d-flex align-items-center alert-dismissible fade show" role="alert">
        <i class="fa-solid fa-triangle-exclamation"></i>
        <div class="ms-2">
            {{ Session::get('failure') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    </div>
@endif
<!-- errors -->
@if ($errors->any())
    <div class="alert alert-danger d-flex align-items-center alert-dismissible fade show mt-3 mb-0" role="alert">
        <div class="ms-2">
            {{-- <strong>Validation Failed</strong>: --}}
            <ul class="mb-0 mt-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    </div>
@endif
<!-- end /. general alerts -->
