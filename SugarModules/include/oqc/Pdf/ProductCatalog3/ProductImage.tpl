<* TODO numbering of figures only works properly if labels is at the bottom of the figure. *>
<* TODO if labels is above \includegraphics or \fitpic the references to the figures all look like "1.1" instead of "figure 1" and "figure 2" *>
<if $product.image_url != null>
\begin{figure}
    \centering
    \fitpic{<$product.image_url>}
    \caption{<$product.name>}
    \label{productImage<$product.id|replace:"-":"">}
\end{figure}
</if>
