<!DOCTYPE html>
   <html lang="en">
   <head>
       <meta charset="UTF-8">
       <meta name="viewport" content="width=device-width, initial-scale=1.0">
       <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
       <title>Register</title>
   </head>
   <body>
       <div class="container">
           <h2>Register</h2>
           <form action="/register" method="post">
               <div class="form-group">
                   <label for="lname">Last Name</label>
                   <input type="text" class="form-control" name="lname" required>
               </div>
               <div class="form-group">
                   <label for="fname">First Name</label>
                   <input type="text" class="form-control" name="fname" required>
               </div>
               <div class="form-group">
                   <label for="email">Email</label>
                   <input type="email" class="form-control" name="email" required>
               </div>
               <div class="form-group">
                   <label for="password">Password</label>
                   <input type="password" class="form-control" name="password" required>
               </div>
               <div class="form-group">
                   <label for="confirm_password">Confirm Password</label>
                   <input type="password" class="form-control" name="confirm_password" required>
               </div>
               <button type="submit" class="btn btn-primary">Register</button>
           </form>
           <?php if (session()->getFlashdata('errors')): ?>
               <div class="alert alert-danger">
                   <?= implode('<br>', session()->getFlashdata('errors')) ?>
               </div>
           <?php endif; ?>
       </div>
   </body>
   </html>