    <ul>
        <?php
            foreach($posts as $post) {
        ?>
        <li class="Comment_single">
            <div class="Comment_box_con clearfix">
                <div class="User_head">
                    <a rel="nofollow" href="<?php echo $post['from_id']; ?>" target="_blank" title="<?php echo $post['from_id']; ?>">
                        <img src="<?php echo $post['from_id']; ?>" alt=""></a>
                </div>
                <div class="Comment_con">
                    <div class="Comment_User">
                        <span>
                            <a class="blue" href="<?php echo $post['from_id']; ?>" target="_blank"><?php echo $post['from_id']; ?></a>
                        </span>
                    </div>
                    <div class="C_summary">
                        <?php echo $post['content']; ?>
                        <span class="Summary-time"><?php echo $this->times->friendlyDate($post['created']); ?></span>
                        <span class="Reply-r">
                            <a class="blue signReplay" href="javascript:;">回复(<b>0</b>)</a>
                        </span>
                    </div>
                </div>
                <div class="qhackbox"></div>
                <div class="qcomment_box_bottom"></div>
            </div>
        </li>
        <?php
        }
        ?>
    </ul>
    <div id="divPageNav" class="pages" style="">
        <?= $this->Paginator->paginate();?>
    </div>