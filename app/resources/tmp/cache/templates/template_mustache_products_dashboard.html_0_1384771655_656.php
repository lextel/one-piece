<ul class="edit_product">
{{# products }}
        <li>
        	<a href="/products/view/{{ id }}/{{ periodId }}" target="_blank">{{ title }}</a>
            <span class="bottom_list">
            	<a href="/products/edit/{{ id }}/{{ periodId}}">编辑</a>
                {{# status }}
                <a href="/products/status/{{ id }}/{{ periodId }}">下架</a>
                {{/ status }}
                {{^ status }}
                <a href="/products/status/{{ id }}/{{ periodId }}">上架</a>
                {{/ status }}
            </span>
        </li>
{{/ products }}
{{^ products }}
    <li>还没有商品哦！~</li>
{{/ products }}
</ul>
