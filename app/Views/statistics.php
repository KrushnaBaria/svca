<div class="row">
    <div class="col-md-6 col-12">
        <div class="card">
            <div class="card-header bg-primary d-flex">
                <h4 class="card-title text-white">Revenue Chart</h4>
                <div class="col-md-2 col-3 ms-auto float-end mb-0">
                    <input type="text" class="form-control text-white" id="r-year-filter" onkeydown="return false;">
                </div>
            </div>
            <div class="card-body">
                <div class="position-relative" style="min-height: 350px;">
                    <div id="revenue-chart"></div>
                    <div id="rev-chart-loading" class="position-absolute top-0 start-0 w-100 h-100 d-flex align-items-center justify-content-center bg-white bg-opacity-75" style="z-index: 10;" aria-busy="true" aria-live="polite">
                        <div class="text-center">
                            <div class="spinner-border text-primary" role="status">
                                <span class="visually-hidden">Loading chart…</span>
                            </div>
                            <div class="mt-2 small text-muted">Loading chart…</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-12">
        <div class="card">
            <div class="card-header bg-primary d-flex">
                <h4 class="card-title text-white">Profit Chart</h4>
                <div class="col-md-2 col-3 ms-auto float-end mb-0">
                    <input type="text" class="form-control text-white" id="p-year-filter" onkeydown="return false;">
                </div>
            </div>
            <div class="card-body">
                <div class="position-relative" style="min-height: 350px;">
                    <div id="profit-chart"></div>
                    <div id="pro-chart-loading" class="position-absolute top-0 start-0 w-100 h-100 d-flex align-items-center justify-content-center bg-white bg-opacity-75" style="z-index: 10;" aria-busy="true" aria-live="polite">
                        <div class="text-center">
                            <div class="spinner-border text-primary" role="status">
                                <span class="visually-hidden">Loading chart…</span>
                            </div>
                            <div class="mt-2 small text-muted">Loading chart…</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-12">
        <div class="card">
            <div class="card-header bg-primary d-flex">
                <h4 class="card-title text-white">Expense Chart</h4>
                <div class="col-md-2 col-3 ms-auto float-end mb-0">
                    <input type="text" class="form-control text-white" id="e-year-filter" onkeydown="return false;">
                </div>
            </div>
            <div class="card-body">
                <div class="position-relative" style="min-height: 350px;">
                    <div id="expense-chart"></div>
                    <div id="exp-chart-loading" class="position-absolute top-0 start-0 w-100 h-100 d-flex align-items-center justify-content-center bg-white bg-opacity-75" style="z-index: 10;" aria-busy="true" aria-live="polite">
                        <div class="text-center">
                            <div class="spinner-border text-primary" role="status">
                                <span class="visually-hidden">Loading chart…</span>
                            </div>
                            <div class="mt-2 small text-muted">Loading chart…</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
