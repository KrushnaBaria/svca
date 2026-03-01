<div class="row">
    <div class="col-md-4">
        <div class="card">
            <div class="card-header text-bg-primary">
                <h5 class="card-title text-white mb-0">Add Task</h5>
            </div>
            <div class="card-body">
                <label for="task" class="form-label">Task</label>
                <input type="text" class="form-control" name="task" id="task">
                <div class="text-center mt-2">
                    <button id="add-task" class="btn btn-primary">Submit</button>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-8">
        <div class="card">
            <div class="card-header text-bg-primary">
                <h5 class="card-title text-white mb-0">Task List</h5>
            </div>
            <div class="card-body">
                <table  id="task-tbl" class="table" style="width:100%">
                    <thead>
                        <th><h6 class="fs-3 fw-semibold">No</h6></th>
                        <th><h6 class="fs-3 fw-semibold">Task</h6></th>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </div>
</div>