
<?php if(!$ajax) { ?>
    <div id='wrap'>
        <h1><?php echo SE_NAME;?> Promotions</h1>

        <div>
            <h2 style='display:inline-block' class="inline-title ">Tags: </h2>
            <input type='text' class='se_filter' style='width:200px;'/>
        </div>

        <div class='promo_container'>
<?php } ?>
        <?php foreach($promotions as $promotion){ ?>
            <div id="c45" class="module wide click-to-module">
              <div class="header module-header click-to-header">
                    <h3 class="module-title" data-tooltip="" aria-describedby="ui-tooltip-0"><?php echo $promotion['name'];?>

                        <?php
                        $tags=$this->sharableContent->getTags($promotion['id']);

                        foreach($tags as $tag)
                            if(!empty($tag['tag']))
                        {?>

                            <span id="BLJfR_1" class="tm-tag tm-tag-info"><span><?php echo $tag['tag'];?></span></span>
                        <?php } ?>

                    </h3>


                </div>

                <div class="module-content click-to-content se-click-to-show">
                    <?php foreach($services[$promotion['id']] as $key=>$service) { ?>

                       <?php  if($service['enabled']==1) echo $this->services[$key]->displayFrontEnd($service);?>



                    <?php }?>
                     <!--
                        <strong>Tags: </strong>

                        <p>
                            <?php foreach($se_tags[$tweet['id']] as $tag) {?>
                                <span id="BLJfR_1" class="tm-tag tm-tag-info"><span><?php echo $tag['tag'];?></span></span>
                            <?php }?>
                        </p>-->

                </div>
            </div>

        <?php } ?>
<?php if(!$ajax) { ?>
    </div>
<?php } ?>