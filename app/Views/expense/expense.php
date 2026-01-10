<div class="col-12">
    <div class="card">
        <div class="card-header text-bg-primary">
            <h4 class="mb-0 text-white">Add Expense</h4>
        </div>
        <div class="card-body">
            <form>
                <div class="d-flex flex-wrap justify-content-center align-items-center">
                    <div class="m-2 col-md-7 col-12">
                        <label class="form-label" for="exp">Expense Description</label>
                        <input type="text" class="form-control" id="exp" placeholder="Enter Expense Description">
                    </div>
                    <div class="m-2 col-md-2 col-12">
                        <label class="form-label" for="center">Center</label>
                        <select type="text" class="form-control" id="center">
                            <option value="">Select Center</option>
                            <?php foreach($centers as $center): ?>
                                <option value="<?= $center['id'] ?>"><?= $center['center'] ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="m-2 col-md-2 col-12">
                        <label class="form-label" for="amount">Amount</label>
                        <input type="number" class="form-control" id="amount" placeholder="Enter Amount" min="0" step="any" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');">
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="text-center">
                        <button class="btn btn-primary" id="sbt-expence">Add</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<div>
    <div class="card">
        <div class="card-header text-bg-primary">
            <h4 class="mb-0 text-white">Expense List</h4>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="expense-tbl">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Description</th>
                            <th>Center</th>
                            <th>Amount</th>
                            <!-- <th>Date</th> -->
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>