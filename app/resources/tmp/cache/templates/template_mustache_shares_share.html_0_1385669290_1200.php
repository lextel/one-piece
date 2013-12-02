<ul class="edit_product">
{{# shares }}
        <li>
            {{^ shareTitle }}
            <a href="/products/view/{{ productId }}/{{ periodId }}" target="_blank">
                (第{{ periodId }}期){{ title }} 
            </a>
            {{/ shareTitle }}
            {{# shareTitle }}
            <a href="/shares/view/{{ productId }}/{{ periodId }}" target="_blank">
                (第{{ periodId }}期){{ title }} <font style="color: #ccc">({{ shareTitle }})</font>
            </a>
            {{/ shareTitle }}
            <span class="bottom_list">
                {{^ shareTitle }}
                   <a href="/shares/add/{{ productId }}/{{ periodId}}">晒单</a>
                {{/ shareTitle }}
                {{# shareTitle }}
                    {{# status }}
                        已审核
                    {{/ status }}
                    {{^ status }}
                        未审核
                    {{/ status }}
                {{/ shareTitle }}
            </span>
        </li>
{{/ shares }}
{{^ shares }}
    <li style="text-align: center; padding-bottom: 20px">啊哦，最近木有中奖呢！~</li>
{{/ shares }}
</ul>
