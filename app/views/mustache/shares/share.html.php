<ul class="edit_product">
{{# shares }}
        <li>
            <a href="/products/view/{{ productId }}/{{ periodId }}" target="_blank">(第{{ periodId }}期){{ title }}</a>
            <span class="bottom_list">
                <?php
                    if($typeId == 2) {
                        echo '<a href="/shares/add/{{ productId }}/{{ periodId}}">晒单</a>';
                    } else {
                        echo '<a href="/shares/delete/{{ productId }}/{{ periodId}}">删除</a>';
                    }
                ?>
            </span>
        </li>
{{/ shares }}
{{^ shares }}
    <li style="text-align: center; padding-bottom: 20px">啊哦，最近木有中奖呢！~</li>
{{/ shares }}
</ul>
