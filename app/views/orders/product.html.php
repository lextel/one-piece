<div name="bitem" class="AllRecordCon">
    <dl>
        <?php
        foreach($orders as $order) {
        ?>
        <dd>
            <ul>
                <li>
                    <a href="javascript:void(0);" class="head_pic"><img src="<?php echo $order['user_id']; ?>"></a>
                    <a href="javascript:void(0);" class="name blue"><?php echo $order['user_id']; ?></a>
                </li>
                <li>云购了<em class="orange"><?php echo $order['count']; ?></em>人次</li>
                <li class="last"><?php echo $order['ordered']; ?></li>
            </ul>
        </dd>
        <?php } ?>
    </dl>
</div>
<?php
if(empty($order)) {
?>
   <div class="NoConMsg"><span>暂无购买记录哦~！</span></div>
<?php
}
?>
<!--分页开始-->
<div id="divPageNav" class="pages" style="">
    <?= $this->Paginator->paginate();?>
</div>
<!--分页结束-->