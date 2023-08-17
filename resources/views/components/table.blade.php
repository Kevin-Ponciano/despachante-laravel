<div class="card">
    <div class="card-header">
        <div class="container-xl">
            <div class="row g-2 align-items-center">
                <div class="col">
                    <div class="page-title me-2">
                        {{ $title }}
                    </div>
                    <div class="page-subtitle mt-2">
                        {{ $subtitle }}
                    </div>
                </div>
                <div class="col-auto ms-auto d-print-none">
                    <div class="btn-list">
                        {{--                        <span class="d-none d-sm-inline">--}}
                        {{--                            <a href="#" class="btn">--}}
                        {{--                              New view--}}
                        {{--                            </a>--}}
                        {{--                        </span>--}}
                        {{$actions = $actions ?? ''}}
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="card-body">
        <div>
            <table id="{{$id}}" class="card-table table table-hover">
                <thead>
                {{$thead}}
                </thead>
                <tbody class="table-tbody">
                {{$tbody}}
                </tbody>
            </table>
        </div>
    </div>
</div>
