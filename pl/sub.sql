SELECT		* 
FROM		middle_chapters	AS middle  
INNER JOIN	big_chapters ON middle.big_chapter_id = big_chapters.id 
INNER JOIN	books ON big_chapters.book_id = books.id 
WHERE		books.id in	(
				SELECT	id
				FROM 	books
			)
ORDER BY		books.display_order ASC
GROUP BY		books.id
