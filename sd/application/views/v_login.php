
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Login Dashboard Bintang</title>
        <link href="<?php echo base_url('css/loginstyles.css') ?>" rel="stylesheet">
        <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/js/all.min.js" crossorigin="anonymous"></script>
    </head>
    <body class="bg-primary">
        <div id="layoutAuthentication">
            <div id="layoutAuthentication_content">
                <main>
                    <div class="container">
                        <div class="row justify-content-center">
                            <div class="col-lg-5">
                                <div class="card shadow-lg border-0 rounded-lg mt-5">
                                    <div class="card-header"><h3 class="text-center font-weight-light my-4"> <?php echo SITE_NAME ?></h3></div>
                                    <div class="card-body">
                                        <div id="message"></div>
                                        <form id="loginForm" class="login" method="post" >	
                                            <div class="form-group">
                                                <label class="small mb-1" for="nik">NIK</label>
                                                <input name="nik" class="form-control" id="nik" type="text" placeholder="NIK" />
                                                <span id="nik_err" class="text-danger"></span>
                                            </div>
                                            <div class="form-group">
                                                <label class="small mb-1" for="password">Password</label>
                                                <input name="password" class="form-control" id="password" type="password" placeholder="Enter password" />
                                                <span id="pass_err" class="text-danger"></span>
                                            </div>
                                            
                                            <div class="form-group d-flex align-items-center justify-content-between mt-4 mb-0"><a class="small" href="password.html">Forgot Password?</a>
                                            <button class="btn btn-primary">Login</button>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="card-footer text-center">
                                        
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </main>
            </div>

        
            <div id="layoutAuthentication_footer">
                <footer class="py-4 bg-light mt-auto">
                    <div class="container-fluid">
                        <div class="d-flex align-items-center justify-content-between small">
                            <div class="text-muted">Copyright &copy; Asuransi Bintang 2019</div>
                            <div>
                                <a href="#">Privacy Policy</a>
                                &middot;
                                <a href="#">Terms &amp; Conditions</a>
                            </div>
                        </div>
                    </div>
                </footer>
            </div>
        </div>
        <script src="https://code.jquery.com/jquery-3.4.1.min.js" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src="js/scripts.js"></script>
    </body>
</html>

    <!-- /.container-fluid -->
        <script type="text/javascript">
         $(document).on("submit", '#loginForm', function () {
                var link ="<?php echo site_url('login/aksi_login'); ?>";
                var linkLogin ="<?php echo site_url('admin'); ?>";
                //e.preventDefault();
                $.post(link, 
                   $('#loginForm').serialize(), 
                   function(data, status, xhr){
                    //console.log(data);
                    obj = JSON.parse(data);
                    console.log(obj);
                
                    if(obj['status']==200){
                        window.location.replace(linkLogin);
                    }else{
                        //$('#message').html('<span id="newmessage" class="text-danger">'+obj['message']+'</span>');
                        if(obj['nik'] != '')
                             {
                              $('#nik_err').html(obj['nik']);
                             }
                        if(obj['password'] != '')
                             {
                              $('#pass_err').html(obj['password']);
                              //alert(obj['password']);
                              //document.getElementById("pass_err").innerHTML = obj['password'];
                             }
                    }
                    
                   });
                return false;
              });

          function ClearFunction() {
            document.getElementById("changePass").reset();
            $('#message').html(''); 
            $('#curret_password_err').html('');
            $('#new_password_err').html('');
            $('#confirm_new_password_err').html('');
          }
          </script>