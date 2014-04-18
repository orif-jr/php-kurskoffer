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
		<id><xsl:value-of select="KEY[@name ='id']/VALUE" /></id>
		<urls>
			<xsl:for-each select="KEY[@name='contents']/MULTIPLE/SINGLE">
				<filename><xsl:value-of select="KEY[@name='filename']/VALUE" /></filename>
				<url><xsl:value-of select="KEY[@name='fileurl']/VALUE" /></url>
			</xsl:for-each>
		</urls>
	    	<chapter><xsl:value-of select="../../../KEY[@name='name']/VALUE" /></chapter>
	    	<title><xsl:value-of select="KEY[@name='name']/VALUE" /></title>
	    	<description><xsl:value-of select="KEY[@name ='description']/VALUE" /></description>
	    </topic>
    </xsl:template>
</xsl:stylesheet>

