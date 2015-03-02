
<* do not show the headline to increase the chance the two pictures are put on the first page of the image appendix *>
<* \chapter{\textbf{<$language.pdf.catalog.imageAppendixTitle>}} *>

<if count($category.products) != 0>
            <foreach from=$category.products item=product_1>
                 <include file="include/oqc/Pdf/ProductCatalog/ProductImage.tpl" product=$product_1>
             </foreach>
</if>
<if count($category.subCategories) != 0>
        		<foreach from=$category.subCategories item=subCategory>
					<include file="include/oqc/Pdf/ProductCatalog/ProductImages2.tpl" category=$subCategory>
				</foreach>
</if>
