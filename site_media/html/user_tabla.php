<tbody>
    <tr>
        <td>{sRfc}</td>
        <td>{sNombre}</td>
        <td>{sApePaterno}</td>
        <td>{sApeMaterno}</td>
        <td>{sEmail}</td>
        <td>{sTipoUsuario}</td>
        <td>{sPassword}<t/d>
        <td>
            <form id="user_edit" action="{GET}" method="GET">
                <input type="hidden" name="sRfc" id="sRfc" value="{sRfc}"/>
                <input type="submit" id="enviar" value="Editar"/>
            </form>
        </td>
        <td>
            <form id="user_delete" action="{DELETE}" method="POST">
                <input type="hidden" name="sRfc" id="sRfc" value="{sRfc}"/>
                <input type="submit" id="enviar" value="Eliminar"/>
            </form>            
        </td>

    </tr>
    