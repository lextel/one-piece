<ul class="edit_product">
{{# shares }}
        <li>
            <a href="/products/view/{{ productId }}/{{ periodId }}" target="_blank">(第{{ periodId }}期){{ title }}</a>
            <span class="bottom_list">
                <a href="/shares/edit/{{ productId }}/{{ periodId}}">编辑</a>
                <a href="/shares/delete/{{ productId }}/{{ periodId}}">删除</a>
            </span>
        </li>
{{/ shares }}
{{^ shares }}
    <li style="text-align: center; padding-bottom: 20px">冷冷清清，凄凄惨惨戚戚！~</li>
{{/ shares }}
</ul>
