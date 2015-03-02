		<if !empty($product.options)>
		\titleformat{\sub<$section>}{\itshape\mdseries\titlerule\vspace{0.7ex}}{\makebox[5em][l]{\thesub<$section>}}{0em}{}[\vspace{0.7ex}\titlerule]
			<foreach from=$product.options item=option name=option>
				<if !empty($option.name)>
				\sub<$section>{<$option.name>}
					<$option.description>
						<if !empty($option.pdfAttachement)>
							\includepdf[pagecommand={\thispagestyle{empty}},pages=-]{<$option.pdfAttachement>}
						</if>
				<if !empty($option.options)>
					<include file="include/oqc/Pdf/ProductCatalog/CategoryOptions.tpl" product=$option section="sub"|cat:$section>
				</if>		
				<else>
					\addtocounter{sub<$section>}{1}
				</if> 
			</foreach>
		\addtocounter{sub<$section>}{-1}
		\titleformat{\sub<$section>}{\itshape\bfseries\titlerule\vspace{0.7ex}}{\makebox[5em][l]{\thesub<$section>}}{0em}{}[\vspace{0.7ex}\titlerule]
		</if>
	

