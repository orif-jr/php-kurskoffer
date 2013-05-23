<?xml version="1.0" encoding="UTF-8"?>

<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
	<xsl:output method="xml" version="1.0" encoding="UTF-8" indent="yes" />
	
	<xsl:template match="/">
		<course>
			<xsl:apply-templates select="/RESPONSE/MULTIPLE/SINGLE/KEY[@name='modules']/MULTIPLE/SINGLE" />
	    </course>
    </xsl:template>
    
    <xsl:template match="SINGLE">
	    <topic>
	    	<chapter><xsl:value-of select="../../../KEY[@name='name']/VALUE" /></chapter>
	    	<title><xsl:value-of select="KEY[@name='name']/VALUE" /></title>
	    	<content><xsl:value-of select="KEY[@name ='description']/VALUE" /></content>
	    </topic>
    </xsl:template>
</xsl:stylesheet>


<!-- 
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
	<xsl:output method="xml" version="1.0" encoding="UTF-8" indent="yes" />

	<xsl:template match="/">
		<xsl:apply-templates select="/RESPONSE/MULTIPLE" />
	</xsl:template>
	
	<xsl:template match="MULTIPLE">
	<course>
		<xsl:for-each select="SINGLE">
		<topic>
			<chapter><xsl:value-of select="KEY[@name='name']/VALUE" /></chapter>
			<xsl:for-each select="KEY[@name='modules']/MULTIPLE/SINGLE">
				<title><xsl:value-of select="KEY[@name='name']/VALUE" /></title>
				<content><xsl:value-of select="KEY[@name='description']/VALUE" /></content>
			</xsl:for-each>
		</topic>
		</xsl:for-each>
	</course>
	</xsl:template>

</xsl:stylesheet>
 -->
 