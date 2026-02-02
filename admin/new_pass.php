<?php  
  include_once ("configs/app_config.php"); ?>
<!DOCTYPE html>
<html lang="en">

<head>

  <base >

  <!-- begin::NextPrime Meta Basic -->
  <meta charset="utf-8">
  <meta name="theme-color" content="#316AFF">
  <meta name="robots" content="index, follow">
  <meta name="author" content="LayoutDrop">
  <meta name="format-detection" content="telephone=no">
  <meta name="keywords" content="HR Management, HR Dashboard, Admin Template, Admin Dashboard, Bootstrap Admin, HR Admin Panel, Employee Management, Human Resources Dashboard, Responsive Admin Template, Web App Dashboard, HRMS Admin, Staff Management Dashboard, Bootstrap 5 Admin, Modern Admin Template, Admin UI Kit, ThemeForest Admin Template, SaaS Dashboard, Project Management Admin, HR Web Application, RTL Dashboard">
  <meta name="description" content="NextPrime is a professional and modern HR Management Admin Dashboard Template built with Bootstrap. It includes light and dark modes, and is ideal for managing employees, attendance, payroll, recruitment, and more — perfect for HR software and admin panels.">
  <!-- end::NextPrime Meta Basic -->

  <!-- begin::NextPrime Meta Social -->
  <meta property="og:url" content="../index-2.html">
  <meta property="og:site_name" content="New Password | NextPrime HR Management Admin Dashboard Template + RTL">
  <meta property="og:type" content="website">
  <meta property="og:locale" content="en_US">
  <meta property="og:title" content="New Password | NextPrime HR Management Admin Dashboard Template + RTL">
  <meta property="og:description" content="NextPrime is a professional and modern HR Management Admin Dashboard Template built with Bootstrap. It includes light and dark modes, and is ideal for managing employees, attendance, payroll, recruitment, and more — perfect for HR software and admin panels.">
  <meta property="og:image" content="../preview.png">
  <!-- end::NextPrime Meta Social -->

  <!-- begin::NextPrime Meta Twitter -->
  <meta name="twitter:card" content="summary">
  <meta name="twitter:url" content="../index-2.html">
  <meta name="twitter:creator" content="@layoutdrop">
  <meta name="twitter:title" content="New Password | NextPrime HR Management Admin Dashboard Template + RTL">
  <meta name="twitter:description" content="NextPrime is a professional and modern HR Management Admin Dashboard Template built with Bootstrap. It includes light and dark modes, and is ideal for managing employees, attendance, payroll, recruitment, and more — perfect for HR software and admin panels.">
  <!-- end::NextPrime Meta Twitter -->

  <!-- begin::NextPrime Website Page Title -->
  <title>New Password | NextPrime HR Management Admin Dashboard Template + RTL</title>
  <!-- end::NextPrime Website Page Title -->

  <!-- begin::NextPrime Mobile Specific -->
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- end::NextPrime Mobile Specific -->

  <!-- begin::NextPrime Favicon Tags -->
  <link rel="icon" type="image/png" href="<?= $base_url ?>/assets/images/favicon.png">
  <link rel="apple-touch-icon" sizes="180x180" href="<?= $base_url ?>/assets/images/apple-touch-icon.png">
  <!-- end::NextPrime Favicon Tags -->

  <!-- begin::NextPrime Google Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com/">
  <link rel="preconnect" href="https://fonts.gstatic.com/" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:ital,wght@0,200..800;1,200..800&amp;display=swap" rel="stylesheet">
  <!-- end::NextPrime Google Fonts -->

  <!-- begin::NextPrime Required Stylesheet -->
  <link rel="stylesheet" href="<?= $base_url ?>/assets/libs/flaticon/css/all/all.css">
  <link rel="stylesheet" href="<?= $base_url ?>/assets/libs/lucide/lucide.css">
  <link rel="stylesheet" href="<?= $base_url ?>/assets/libs/fontawesome/css/all.min.css">
  <link rel="stylesheet" href="<?= $base_url ?>/assets/libs/simplebar/simplebar.css">
  <link rel="stylesheet" href="<?= $base_url ?>/assets/libs/node-waves/waves.css">
  <link rel="stylesheet" href="<?= $base_url ?>/assets/libs/bootstrap-select/css/bootstrap-select.min.css">
  <!-- end::NextPrime Required Stylesheet -->

  <!-- begin::NextPrime CSS Stylesheet -->
  <link rel="stylesheet" href="<?= $base_url ?>/assets/css/styles.css">
  <!-- end::NextPrime CSS Stylesheet -->

  <!-- begin::NextPrime Googletagmanager -->
  <script async src="https://www.googletagmanager.com/gtag/js?id=G-XWVQM68HHQ"></script>
  <script>
		window.dataLayer = window.dataLayer || [];
		function gtag(){dataLayer.push(arguments);}
		gtag('js', new Date());

		gtag('config', 'G-XWVQM68HHQ', {
			'cookie_flags': 'SameSite=None;Secure',
			'send_page_view': true
		});
	</script>
  <!-- end::NextPrime Googletagmanager -->

</head>

<body>
  <div class="page-layout">

    <div class="auth-cover-wrapper">
      <div class="row g-0">
        <div class="col-lg-6">
          <div class="auth-cover" style="background-image: url(<?= $base_url ?>/assets/images/auth/auth-cover-bg.png);">
            <div class="clearfix">
              <img src="<?= $base_url ?>/assets/images/auth/auth.png" alt="" class="img-fluid cover-img ms-5">
              <div class="auth-content">
                <h1 class="display-6 fw-bold">Welcome Back!</h1>
                <p>Our HR Management & Administration ensure your organization runs smoothly, focusing on people, compliance, and efficiency to drive growth and employee satisfaction.</p>
              </div>
            </div>
          </div>
        </div>
        <div class="col-lg-6 align-self-center">
          <div class="p-3 p-sm-5 maxw-450px m-auto">
            <div class="mb-4 text-center">
              <a href="index.html" aria-label="NextPrime logo">
                <img class="visible-light" src="assets/images/logo-full.svg" alt="NextPrime logo">
                <img class="visible-dark" src="assets/images/logo-full-white.svg" alt="NextPrime logo">
              </a>
            </div>
            <div class="text-center mb-5">
              <h5 class="mb-1">Welcome to NextPrime</h5>
              <p>Enter your email to reset your password.</p>
            </div>
            <form action="http://../authentication/login-cover.html">
              <div class="mb-4">
                <label class="form-label" for="newPassword">New Password</label>
                <input type="password" class="form-control" id="newPassword" placeholder="********">
              </div>
              <div class="mb-4">
                <label class="form-label" for="confirmPassword">Confirm Password</label>
                <input type="password" class="form-control" id="confirmPassword" placeholder="********">
              </div>
              <div class="mb-4">
                <div class="form-check mb-0">
                  <input class="form-check-input" type="checkbox" id="termsConditions" name="terms">
                  <label class="form-check-label" for="termsConditions">
                    I Agree & <a href="javascript:void(0);">Terms and conditions.</a>
                  </label>
                </div>
              </div>
              <div class="clearfix">
                <button type="submit" value="Submit" class="btn btn-primary waves-effect waves-light w-100 mb-3">Submit</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>

  </div>
  <!-- begin::NextPrime Page Scripts -->
  <script src="<?= $base_url ?>/assets/libs/global/global.min.js"></script>
  <script src="<?= $base_url ?>/assets/js/appSettings.js"></script>
  <script src="<?= $base_url ?>/assets/js/main.js"></script>
  <!-- end::NextPrime Page Scripts -->
</body>

</html>