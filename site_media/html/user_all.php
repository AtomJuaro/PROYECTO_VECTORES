<table>
	<tr>
		<TH COLSPAN=4>
            <div class="item_requerid">Selecciona el tipo de usuario:</div>
        </th>
    </tr>
    <tr>
    <td>
    <form id="usu_abatizador" action="{ALL_USERS}" method="GET">
        <div class="form_requerid"><input type="hidden" name="sTipoUsuario" 
         id="sTipoUsuario" value="Abatizador"></div>
        <div class="form_button"><input type="submit"  
         id="enviar" value="Abarizadores"></div>
    </form>
    </td>
    <td>
    <form id="usu_aplicador" action="{ALL_USERS}" method="GET">
        <div class="form_requerid"><input type="hidden" name="sTipoUsuario" 
         id="sTipoUsuario" value="Aplicador"></div>
        <div class="form_button"><input type="submit"  
         id="enviar" value="Aplicadores"></div>
    </form>
	</td>
    <td>
    <form id="usu_methodA" action="{ALL_USERS}" method="GET">
        <div class="form_requerid"><input type="hidden" name="sTipoUsuario" 
         id="sTipoUsuario" value="TipoA"></div>
        <div class="form_button"><input type="submit"  
         id="enviar" value="TipoA"></div>
    </form>
    </td> 
	</tr>
</table>