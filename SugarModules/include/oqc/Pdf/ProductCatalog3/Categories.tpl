<if isset($rootCategories) && not empty($rootCategories)>
<foreach from=$rootCategories item=category>
	\label{categoryId<$category.id|replace:"-":"">}
	<include file="include/oqc/Pdf/ProductCatalog3/Categories.tpl" rootCategories=$category.subCategories section="sub"|cat:$section>
</foreach>
</if>

