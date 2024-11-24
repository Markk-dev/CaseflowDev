<!DOCTYPE html>
   <html lang="en">
   <head>
       <meta charset="UTF-8">
       <meta name="viewport" content="width=device-width, initial-scale=1.0">
       <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
       <title>Login</title>
   </head>
   <body>
       <div class="container">
           <h2>Login</h2>
           <form action="/login" method="post">
               <div class="form-group">
                   <label for="email">Email</label>
                   <input type="email" class="form-control" name="email" required>
               </div>
               <div class="form-group">
                   <label for="password">Password</label>
                   <input type="password" class="form-control" name="password" required>
               </div>
               <button type="submit" class="btn btn-primary">Login</button>
           </form>
           <?php if (session()->getFlashdata('error')): ?>
               <div class="alert alert-danger">
                   <?= session()->getFlashdata('error') ?>
               </div>
           <?php endif; ?>
       </div>
   </body>
   </html>