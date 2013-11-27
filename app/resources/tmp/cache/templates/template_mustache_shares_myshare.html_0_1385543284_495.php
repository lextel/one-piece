<ul class="edit_product">
{{# shares }}
<li>
    <a href="/products/view/{{ product_id }}/{{ period_id }}" target="_blank">
       (第{{ period_id }}期){{ title }} 
   </a>
   <span class="bottom_list">
    {{# status }}
        已审核
    {{/ status }}
    {{^ status }}
        未审核
    {{/ status }}
   </span>
</li>
{{/ shares }}
{{^ shares }}
    <li style="text-align: center; padding-bottom: 20px">啊哦，你还没晒过单呢！~</li>
{{/ shares }}
</ul>
