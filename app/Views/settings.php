<h1>Settings</h1>
<div class="row">
    <div class="col-lg-3">
        <div class="card">
            <div class="card-header text-bg-primary">
                <h4 class="mb-0 text-white">Add Center</h4>
            </div>
            <div class="card-body">
                <form>
                    <div class="col-md-12">
                        <div class="mb-3">
                            <input type="text" class="form-control" id="center_name" placeholder="Enter Center Name">
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="mb-3 text-center">
                            <button class="btn btn-primary" id="sbt-center">Submit</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="col-lg-9">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title mb-3">Centers</h4>
                <table id="centers-tbl" class="display responsive nowrap" style="width:100%">
                    <thead>
                        <tr>
                            <th>Id</th>
                            <th>Name</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-3">
        <div class="card">
            <div class="card-header text-bg-primary">
                <h4 class="mb-0 text-white">Add Course</h4>
            </div>
            <div class="card-body">
                <form>
                    <div class="col-md-12">
                        <div class="mb-3">
                            <label for="course_name" class="form-label">Course Name</label>
                            <input type="text" class="form-control" id="course_name" placeholder="Enter Course Name">
                        </div>
                        <div class="mb-3">
                            <label for="course_price" class="form-label">Course Price</label>
                            <input type="text" class="form-control" id="course_price" placeholder="Enter Price">
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="mb-3 text-center">
                            <input type="hidden" id="course_id" value="">
                            <button class="btn btn-primary" id="sbt-course">Submit</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="col-lg-9">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title mb-3">Courses</h4>
                <table id="course-tbl" class="display responsive nowrap" style="width:100%">
                    <thead>
                        <tr>
                            <th>Id</th>
                            <th>Course</th>
                            <th>Price</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </div>
</div>
