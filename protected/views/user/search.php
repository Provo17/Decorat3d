<!--dash box-->
<section class="dash-box">
    <div class="color-box3">
        <div class="selectPart111">
            <div class="container containerPart121">
                <div class="row">
                    <div class="form-field">
                        <form action="<?php echo Yii::app()->createUrl('user/searchResult')?>">                            
                            <div class="col-md-6 col-sm-6 col-xs-6 searchPart">
                                <div class="searchFielddd"><label>Search</label>
                                    <input type="text"  name="key"class="searchFields"/></div>                                
                            </div>
                            <div class="col-md-6 col-sm-6 col-xs-6 searchFieldPart">
                                <div class="selectBox1">
                                    <select name="search_type">
                                        <option value="projects">Projects</option>
                                        <option value="purchased_designs">Purchased Designs</option>
                                        <option value="catalog">Catalogs</option>
                                        <option value="purchased_catalog">Purchased Catalogs</option>
                                        <option value="manufacturer_catalog">Manufacturer Catalogs</option>
                                        <option value="employer-or-designer">Employer / Designer</option>
                                        <option value="manufacturer">Manufacturer</option>
                                    </select>
                                <div class="submit"><input type="submit" value="Go" class="btn btn-default reg-btn"></div>
                                </div>
                            </div>
                        </form>
                        <div class="clearfix"></div>
                    </div>
                    <div class="clearfix"></div>
                </div>
            </div>
        </div>
    </div>
</section>
<!--/dash box-->