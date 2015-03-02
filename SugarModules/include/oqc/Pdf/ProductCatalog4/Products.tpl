\textbf{\ref{categoryId<$category.id|replace:"-":"">}} & \multicolumn{2}{p{0.7\textwidth}}{\textbf{<$category.name>}} & \setcounter{oqc_pn}{1} \\
\midrule
		<if !empty($category.products)>
			<foreach from=$category.products item=product name=products>
				\ref{categoryId<$category.id|replace:"-":"">}.\arabic{oqc_pn} &
			
				<$product.name><if !empty($product.image_url)> (see image \ref{productImage<$product.id|replace:"-":"">} on page \pageref{productImage<$product.id|replace:"-":"">})</if> &
				<$product.unit> & 
				<$currency.currency_symbol><sugar_currency_format var=$product.price*$currency.currency_ratio*$discount round=true decimals=2 currency_symbol=false> \addtocounter{oqc_pn}{1} \\
				
			</foreach>
			
			\midrule	
		</if>

		<if isset($category.subCategories) && not empty($category.subCategories)>
		<foreach from=$category.subCategories item=subCategory>		
			<include file="include/oqc/Pdf/ProductCatalog4/Products.tpl" category=$subCategory header=true>
		</foreach>
		</if>
