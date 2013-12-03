    <ul>
        <?php
            foreach($comments as $comment) {
        ?>
        <li class="Comment_single">
            <div class="Comment_box_con clearfix">
                <div class="User_head">
                    <a rel="nofollow" href="/users/info/<?php echo $comment['user_id']; ?>" target="_blank" title="<?php echo $comment['user']['nickname']; ?>">
                        <img src="<?php echo $comment['user']['avatar']; ?>" alt=""></a>
                </div>
                <div class="Comment_con">
                    <div class="Comment_User">
                        <span>
                            <a class="blue" href="/users/info/<?php echo $comment['user_id']; ?>" target="_blank"><?php echo $comment['user']['nickname']; ?></a>
                        </span>
                    </div>
                    <div class="C_summary">
                        <?php echo $comment['content']; ?>
                        <span class="Summary-time"><?php echo $this->times->friendlyDate($comment['created']); ?></span>
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