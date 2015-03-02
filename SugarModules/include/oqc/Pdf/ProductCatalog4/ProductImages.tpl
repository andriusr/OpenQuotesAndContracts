
<* do not show the headline to increase the chance the two pictures are put on the first page of the image appendix *>
<* \chapter{\textbf{<$language.pdf.catalog.imageAppendixTitle>}} *>

<if count($rootCategories) != 0>
    <foreach from=$rootCategories item=category name=cycle1>
        <if count($category.products) != 0>
            <foreach from=$category.products item=product_1 name=cycle2>
                    <include file="include/oqc/Pdf/ProductCatalog4/ProductImage.tpl" product=$product_1>
            </foreach>
        </if>
        	<if count($category.subCategories) != 0>
        		<foreach from=$category.subCategories item=subCategory name=cycle3>
					<include file="include/oqc/Pdf/ProductCatalog4/ProductImages2.tpl" category=$subCategory>
				</foreach>
			</if>
    </foreach>
</if>
