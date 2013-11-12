<ul class="edit_product">
{{# products }}
        <li>
        	<a href="/products/view/{{ _id }}" target="_blank">{{ title }}</a>
            <span class="bottom_list">
            	<a href="/products/edit/{{ _id }}">编辑</a>
                <a href="/products/status/{{ _id }}">上架</a>
            </span>
        </li>
{{/ products }}
</ul>
