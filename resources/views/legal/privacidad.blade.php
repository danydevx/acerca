@extends('layouts.legal')

@section('content')
    <div class="legal-content">
        <h1>Politica de privacidad</h1>
        <p class="updated">Ultima actualizacion: {{ date('d/m/Y') }}</p>

        <p>
            Esta Politica describe como {{ config('app.name', 'Acerca.site') }} ("nosotros") recopila, usa y
            protege la informacion personal de quienes utilizan la Plataforma y de los visitantes de los
            minisites publicos generados.
        </p>

        <h2>1. Datos que recopilamos</h2>
        <ul>
            <li><strong>Datos de cuenta:</strong> nombre, correo electronico, contrasena (almacenada cifrada) y datos de facturacion cuando corresponda.</li>
            <li><strong>Datos del negocio:</strong> nombre comercial, descripcion, logo, direccion, horarios, servicios, productos, imagenes y demas contenido que publiques.</li>
            <li><strong>Datos tecnicos:</strong> direccion IP, agente de navegador, paginas visitadas y registros de actividad necesarios para seguridad y mejora del servicio.</li>
            <li><strong>Cookies y tecnologias similares:</strong> para mantener la sesion iniciada, recordar preferencias y analizar uso agregado.</li>
        </ul>

        <h2>2. Finalidades</h2>
        <p>Usamos los datos para:</p>
        <ul>
            <li>Crear y mantener tu cuenta, autenticar accesos y prevenir fraudes.</li>
            <li>Mostrar tu tarjeta digital y minisite publico a quienes visiten tu enlace o QR.</li>
            <li>Procesar pagos y emitir comprobantes cuando uses funciones pagas.</li>
            <li>Enviarte comunicaciones operativas y, si lo autorizas, comerciales.</li>
            <li>Cumplir obligaciones legales y responder a requerimientos de autoridades.</li>
        </ul>

        <h2>3. Bases legales</h2>
        <p>
            Tratamos tus datos sobre la base de la ejecucion del contrato (prestacion del servicio), tu
            consentimiento (comunicaciones comerciales y cookies no esenciales), el cumplimiento de
            obligaciones legales y nuestro interes legitimo en mantener la Plataforma segura.
        </p>

        <h2>4. Comparticion con terceros</h2>
        <p>
            No vendemos tus datos personales. Solo los compartimos con proveedores que nos ayudan a operar
            la Plataforma (proveedores de infraestructura, pasarela de pagos, envio de correo electronico)
            bajo acuerdos de confidencialidad y solo en la medida necesaria para prestar el servicio.
        </p>

        <h2>5. Conservacion</h2>
        <p>
            Mantenemos tus datos mientras tu cuenta este activa y durante el plazo necesario para cumplir
            obligaciones legales o atender posibles responsabilidades. Cuando los datos dejan de ser
            necesarios, se eliminan o anonimizan de forma segura.
        </p>

        <h2>6. Tus derechos</h2>
        <p>
            Puedes acceder, rectificar, actualizar o solicitar la eliminacion de tus datos personales desde
            tu panel o escribiendo a traves de la seccion de soporte. Tambien puedes oponerte al tratamiento
            o solicitar portabilidad cuando corresponda.
        </p>

        <h2>7. Seguridad</h2>
        <p>
            Aplicamos medidas tecnicas y organizativas razonables (cifrado en transito, acceso restringido,
            copias de respaldo) para proteger tus datos. Aun asi, ningun sistema es 100% seguro; te pedimos
            cuidar tus credenciales y avisarnos ante cualquier incidente.
        </p>

        <h2>8. Menores</h2>
        <p>
            La Plataforma no esta dirigida a menores de 16 anos. Si detectamos datos de un menor sin
            autorizacion de su responsable, los eliminaremos.
        </p>

        <h2>9. Cambios</h2>
        <p>
            Podemos actualizar esta Politica para reflejar cambios legales o del producto. Te avisaremos
            por correo electronico o mediante un aviso visible dentro de la Plataforma.
        </p>

        <h2>10. Contacto</h2>
        <p>
            Para cualquier consulta sobre privacidad, contactanos a traves de la seccion de soporte
            disponible en <a href="{{ url('/login') }}">{{ url('/login') }}</a>.
        </p>
    </div>
@endsection