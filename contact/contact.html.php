<!-- Header Section -->
<?php include '../includes/header.inc.php'; ?>

<!-- Contact Form -->
<div class="form_wrapper">
    <h1 class="form-heading">Contact Us</h1>
    <form class="form_container" action="" method="POST">
        <div class="form-control">
            <input type="text" id="firstName" name="firstName" class="form-input" placeholder="First Name *" required>
        </div>
        <div class="form-control">
            <input type="text" id="lastName" name="lastName" class="form-input" placeholder="Last Name">
        </div>
        <div class="form-control">
            <input type="text" id="location" name="location" class="form-input" placeholder="Location">
        </div>
        <div class="form-control">
            <input type="email" id="email" name="email" class="form-input" placeholder=" eg : sample@gmail.com *" required>
        </div>
        <div class="form-control">
            <input type="text" id="subject" name="subject" class="form-input" placeholder="Your Subject">
        </div>
        <div class="mb">
            <textarea id="message" name="message" class="form-input  textarea" rows="7" placeholder="Your Message in details"></textarea>
        </div>
        <div>
            <?php if ($inserted) {
                echo "<p class='success'>Thanks! We will come back to you soon.";
            } ?>
        </div>
        <button type="submit" class="form-btn">Submit</button>
    </form>
</div>

<!-- Footer Section -->
<?php include '../includes/footer.inc.php'; ?>