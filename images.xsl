<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
	<xsl:template match="/">
		<html>
			<head>
				<title></title>
			</head>
			<body>
				<h2>Slideshow</h2>
				<table border ="1">
					<xsl:for-each select="images/image">
						<tr>
							<td bgcolor="#FF00FF">
								<xsl:value-of select="title"/>
							</td>
						</tr>
					</xsl:for-each>
				</table>
			</body>
		</html>
	</xsl:template>
</xsl:stylesheet>




