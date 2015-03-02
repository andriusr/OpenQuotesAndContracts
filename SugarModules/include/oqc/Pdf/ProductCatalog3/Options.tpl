\setcounter{oqc_opt}{0}
<if !empty($product.options)>
<foreach from=$product.options item=option name=option key=i>
<if $i != 0>~</if>~\addtocounter{oqc_opt}{1}<$category.number>.\alph{oqc_pn}.\arabic{oqc_opt}&
\textit{<$option.name>}&
<$option.unit>& 
<$currency.currency_symbol><sugar_currency_format var=$option.price*$currency.currency_ratio*$discount round=true decimals=2 currency_symbol=false>\\
<if !empty($option.options)>
<include file="include/oqc/Pdf/ProductCatalog3/Options.tpl" product=$option>
</if>	
</foreach>
</if>
