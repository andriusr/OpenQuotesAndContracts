<if isset($rootCategories) && not empty($rootCategories)>

<foreach from=$rootCategories item=category>
	\<$section>{<$category.name>}\label{categoryId<$category.id|replace:"-":"">}

		<$category.description>

		<if !empty($category.products)>
		\renewcommand{\thesub<$section>}{\arabic{section}.<if $section != "section"><$counter></if>\alph{sub<$section>}}
		\titleformat{\sub<$section>}{\itshape\bfseries\titlerule\vspace{0.7ex}}{\makebox[5em][l]{\thesub<$section>}}{0em}{}[\vspace{0.7ex}\titlerule]
			<foreach from=$category.products item=product name=products>
				<if !empty($product.description)>
				\sub<$section>{<$product.name>}
					<$product.description>
						<if !empty($product.pdfAttachement)>
							\includepdf[pagecommand={\thispagestyle{empty}},pages=-]{<$product.pdfAttachement>}
						</if>
				<if !empty($product.options)>
					<include file="include/oqc/Pdf/ProductCatalog/CategoryOptions.tpl" product=$product section="sub"|cat:$section>
				</if>		
				<else>
					\addtocounter{sub<$section>}{1}
				</if> 
			</foreach>
		\addtocounter{sub<$section>}{-1}
		\renewcommand{\thesub<$section>}{\arabic{section}.<if $section != "section"><$counter></if>\arabic{sub<$section>}}
		\titleformat{\sub<$section>}{\sffamily\bfseries\titlerule\vspace{0.7ex}}{\makebox[5em][l]{\thesub<$section>}}{0em}{}[\vspace{0.7ex}\titlerule]
		</if>
	<assign var='current_counter' value=$counter|cat:'\arabic{sub'|cat:$section|cat:'}.'>	
	<include file="include/oqc/Pdf/ProductCatalog/Categories.tpl" rootCategories=$category.subCategories section="sub"|cat:$section counter=$counter|cat:$current_counter>
</foreach>
</if>

