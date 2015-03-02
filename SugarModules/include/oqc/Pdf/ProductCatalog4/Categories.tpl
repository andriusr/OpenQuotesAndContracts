<if isset($rootCategories) && not empty($rootCategories)>
<foreach from=$rootCategories item=category>
	\<$section>{<$category.name>}\label{categoryId<$category.id|replace:"-":"">}

		<$category.description>

		<if !empty($category.products)>
			<foreach from=$category.products item=product name=products>
				<if !empty($product.description)>
					\sub<$section>{<$product.name>}
					<$product.description>
						<if !empty($product.pdfAttachement)>
							\includepdf[pagecommand={\thispagestyle{empty}},pages=-]{<$product.pdfAttachement>}
						</if>		
				<else>
					\addtocounter{sub<$section>}{1}
				</if> 
			</foreach>
		</if>
		
	<include file="include/oqc/Pdf/ProductCatalog4/Categories.tpl" rootCategories=$category.subCategories section="sub"|cat:$section>
</foreach>
</if>

