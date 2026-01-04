        <?php if (session('error') !== null) : ?>
        <div class="alert alert-danger" role="alert"><?= session('error') ?></div>
                <?php elseif (session('errors') !== null) : ?>
                    <div class="alert alert-danger" role="alert">
                        <?php if (is_array(session('errors'))) : ?>
                            <?php foreach (session('errors') as $error) : ?>
                                <?= $error ?>
                                <br>
                            <?php endforeach ?>
                        <?php else : ?>
                            <?= session('errors') ?>
                        <?php endif ?>
                    </div>
                <?php endif ?>
          <!-- --------------------------------------------------- -->
          <!--  Form Basic Start -->
          <!-- --------------------------------------------------- -->
          <div class="d-flex align-items-center justify-content-center col-xl-10 col-xxl-6 ">
            <div class="card">
              <div class="card-body">
                <h5 class="mb-3">Add User</h5>
                <form action="<?= url_to('adduser') ?>" method="post">
                        <div class="row">
                        <!-- Firstname -->
                            <div class="col mb-3">
                                <label for="floatingFirstnameInput" class="form-label"> First Name </label>
                                <input type="text" class="form-control" id="floatingFirstnameInput" name="first_name" inputmode="text" autocomplete="first_name" placeholder= "First Name" value="<?= old('first_name') ?>"  required>
                            </div>

                        <!-- Lastname -->
                            <div class="col mb-3">
                                <label for="floatingLastnameInput" class="form-label"> Last Name </label>
                                <input type="text" class="form-control" id="floatingLastnameInput" name="last_name" inputmode="text" autocomplete="last_name" placeholder= "Last Name" value="<?= old('last_name') ?>" required>
                            </div>
                        </div>

                        <!-- Email -->
                        <div class="mb-3">
                            <label for="floatingEmailInput" class="form-label"><?= lang('Auth.email') ?></label>
                            <input type="email" class="form-control" id="floatingEmailInput" name="email" inputmode="email" autocomplete="email" placeholder="<?= lang('Auth.email') ?>" value="<?= old('email') ?>" required>
                        </div>

                        <!-- Select Role -->
                        <div class="mb-3">
                                <label for="selectRole" class="form-label">Select Role</label>
                                <select class="form-select" id="selectRole" name="user_role" required>
                                <option value="user">User</option>
                                <option value="admin">Admin</option>
                                <option value="superadmin">Super Admin</option>
                                </select>
                        </div>

                        <!-- Password -->
                        <div class="mb-4">
                            <label for="floatingPasswordInput" class="form-label"><?= lang('Auth.password') ?></label>
                            <input type="password" class="form-control" id="floatingPasswordInput" name="password" inputmode="text" autocomplete="new-password" placeholder="<?= lang('Auth.password') ?>" required>
                        </div>

                        <!-- Password (Again) -->
                        <div class="mb-4">
                            <label for="floatingPasswordConfirmInput" class="form-label"><?= lang('Auth.passwordConfirm') ?></label>
                            <input type="password" class="form-control" id="floatingPasswordConfirmInput" name="password_confirm" inputmode="text" autocomplete="new-password" placeholder="<?= lang('Auth.passwordConfirm') ?>" required>
                        </div>

                        <div class="d-grid col-12 col-md-8 mx-auto m-3">
                            <button type="submit" class="btn btn-primary btn-block"><?= lang('Auth.register') ?></button>
                        </div> 
                </form>
              </div>
            </div>
          </div>
        </div>
