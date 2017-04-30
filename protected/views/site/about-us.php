<section class="main">
    <div class="container">
        <?php
        if ($this->pageDetails && is_object($this->pageDetails))
        {
            echo $this->pageDetails->content;
        }
        ?>
    </div>
</section>