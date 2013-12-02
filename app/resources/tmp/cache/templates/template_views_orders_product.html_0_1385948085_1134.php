<?php if($orders): ?>
<div name="bitem" class="AllRecordCon">
    <dl>
        <?php
        foreach($orders as $order) {
        ?>
        <dd>
            <ul>
                <li>
                    <a href="javascript:void(0);" class="head_pic"><img style="width:30px; height:30px" src="<?php echo $order['user']['avatar']; ?>"></a>
                    <a href="javascript:void(0);" class="name blue"><?php echo $order['user']['nickname']; ?></a>
                </li>
                <li>云购了<em class="orange"><?php echo $order['count']; ?></em>人次</li>
                <?php 
                    $times = explode('.', $order['ordered'])
                ?>
                <li class="last"><?php echo date('Y-m-d H:i:s', $times[0]) . '.' . $times[1]; ?></li>
            </ul>
        </dd>
        <?php } ?>
    </dl>
</div>
<?php endif; ?>
<?php
if(empty($order)) {
?>
   <div class="NoConMsg"><span>暂无购买记录哦~！</span></div>
<?php
}
?>
<!--分页开始-->
<div id="divPageNav" class="pages" style="">
    <?php echo $this->Paginator->paginate(); ?>
</div>
<!--分页结束-->