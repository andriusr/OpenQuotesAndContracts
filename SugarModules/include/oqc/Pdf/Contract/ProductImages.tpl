<if $imagesExist>
    \newpage
    <* do not show the headline to increase the chance the two pictures are put on the first page of the image appendix *>
    <* \chapter{\textbf{<$language.pdf.catalog.imageAppendixTitle>}} *>

    <if is_array($oneTimeServices) && count($oneTimeServices) != 0>
        <foreach item=service from=$oneTimeServices>
            <include file="include/oqc/Pdf/Contract/ProductImage.tpl">
        </foreach>
    </if>

    <if is_array($services) && count($services) != 0>
        <foreach item=service from=$services>
            <include file="include/oqc/Pdf/Contract/ProductImage.tpl">
        </foreach>
    </if>
</if>