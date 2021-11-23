<?php
    $projectStepImages = array(get_field('image_01'), get_field('image_02'), get_field('image_03'));
    $skillLevel = get_field('skill_level');
    $time = get_field('time');
    $adultSupervision = get_field('adult_supervision_needed');
    $youtubeUrl = get_field('youtube_video');
    $tags = get_the_tags()
?>

<div class="row project-instructions">
    <!-- Project instructions -->
    <div class="col-xs-12 <?php if(!in_array(false, $projectStepImages)){ echo 'col-sm-6'; } else { echo 'col-sm-12'; }; ?> ">
        <?php if($skillLevel || $time || $adultSupervision): ?>
            <div class="row top-instruction-box">
                <?php if($skillLevel): ?>
                    <div class="col-xs-12 <?php if(!in_array(false, $projectStepImages)){ echo 'col-sm-12'; } else { echo 'col-sm-4'; }; ?>">
                        <p class="bold"><strong>Skill Level</strong></p>
                        <p><?php echo $skillLevel; ?></p>
                    </div>
                <?php endif; ?>

                <?php if($time): ?>
                    <div class="col-xs-12 <?php if(!in_array(false, $projectStepImages)){ echo 'col-sm-12'; } else { echo 'col-sm-6'; }; ?>">
                        <p class="bold"><strong>Time to Make</strong></p>
                        <p><?php echo $time; ?></p>
                    </div>
                <?php endif; ?>

                <?php if($adultSupervision): ?>
                    <div class="col-xs-12 <?php if(!in_array(false, $projectStepImages)){ echo 'col-sm-12'; } else { echo 'col-sm-6'; }; ?>">
                        <p class="bold"><strong>Adult Supervision Needed</strong></p>
                        <p><?php echo $adultSupervision; ?></p>
                    </div>
                <?php endif; ?>
            </div>

            <?php if($youtubeUrl): ?>
                <?php echo embedYoutubeVideo($youtubeUrl, 'mobile'); ?>
            <?php endif; ?>
        <?php endif; ?>

        <?php if(get_field('how_to_make')): ?>
            <p class="bold"><strong>How to Make</strong></p>
            <?php echo get_field('how_to_make'); ?>
        <?php endif; ?>

        <!-- Project step images -->
        <div class="col-xs-12 col-sm-6 visible-xs mobile-images"> 
            <?php foreach($projectStepImages as $projectStepImage): ?>
                <?php if($projectStepImage){
                    $image = wp_get_attachment_image_src($projectStepImage,"step-image"); ?>
                    <img class="lozad" data-src="<?php echo $image[0];?>" alt="<?php echo get_the_title()?>"/>            
                <?php } ?>
            <?php endforeach; ?>
        </div>

        <?php if(get_field('top_tip')): ?>
            <p class="bold"><strong>Top Tip</strong></p>
            <p><?php echo get_field('top_tip'); ?></p>
        <?php endif; ?>

        <?php if(get_field('template')): ?>
            <p class="bold template-list"><strong>Template</strong></p>
            <?php $template = get_field('template'); ?>
            <a href="<?php echo $template; ?>" target="_blank" title="Download">Download</a>
        <?php endif; ?>
    </div>

    <!-- Project step images & Youtube video -->
    <div class="col-xs-12 col-sm-6 no-gutter-sm hidden-xs desktop-images">
        <!-- <?php echo print_r($tags)?> -->
        <?php if ( $tags ) :?> 
        <div class="tagged-with">
					<!-- Post tags -->
					<?php the_tags('<div class="tag-with">Tagged with: </div><div class="tags">', ', ', '</div>' ); ?>
		</div>
        <?php endif; ?>
        <?php if($youtubeUrl): ?>
            <?php echo embedYoutubeVideo($youtubeUrl); ?>
        <?php endif; ?>

        <?php foreach($projectStepImages as $projectStepImage): ?>
            <?php if($projectStepImage){
                $image = wp_get_attachment_image_src($projectStepImage,"step-image"); ?>
                <img class="lozad" data-src="<?php echo $image[0];?>" alt="<?php echo get_the_title()?>"/>            
            <?php } ?>
        <?php endforeach; ?>
    </div>

    <div class="col-xs-12 no-gutter-sm">
        <div class="visible-xs col-sm-6 tagged-with">
            <!-- Post tags -->
            <p><?php the_tags('<div class="tag-with">Tagged with: </div>', ', ' ); ?></p>
        </div>
    </div>
</div>