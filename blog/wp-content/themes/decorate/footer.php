<?php $main_url = '';
$main_url = str_replace('blog','',site_url());
?>
<?php
/**
 * The template for displaying the footer
 *
 * Contains footer content and the closing of the #main and #page div elements.
 *
 * @package WordPress
 * @subpackage Twenty_Thirteen
 * @since Twenty Thirteen 1.0
 */
?>

</section><!-- #main -->
<footer  class="footer">
    <div class="container">

        <ul class="foot-nav" >
            <li> <a href="<?php echo $main_url; ?>how-it-works.html">How it works</a></li>    <li> <a href="<?php echo $main_url; ?>acceptable-use-policy.html">Acceptable Use Policy</a></li>
        </ul>
        <ul class="foot-nav" >
            <li> <a href="<?php echo $main_url; ?>about-us.html">About us</a></li>
            <li> <a href="<?php echo $main_url; ?>contact-us.html">Contact Us</a></li>
            <li> <a href="<?php echo $main_url; ?>privacy-policy.html">Privacy Policy</a></li>
            <li> <a href="<?php echo $main_url; ?>terms-and-conditions.html">Terms and Conditions</a></li>
            <li> <a href="<?php echo $main_url; ?>faq.html">FAQ</a></li>
        </ul>
        <div class="row">
            <div class="col-sm-12">
                <div align="center">Copyright &copy; 2015  Decorat3d, All Rights Reserved.</div>
            </div>
        </div>
    </div>
</footer>
<!--/footer-->
</div><!-- #page -->

<?php wp_footer(); ?>
</body>
</html>