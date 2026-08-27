@extends('layouts.legal')

@section('content')
    <div class="legal-content">
        <h1>Terminos de servicio</h1>
        <p class="updated">Ultima actualizacion: {{ date('d/m/Y') }}</p>

        <p>
            Estos Terminos de servicio regulan el uso de {{ config('app.name', 'Acerca.site') }} ("la Plataforma"),
            una herramienta para crear y compartir tarjetas digitales de presentacion, gestion de negocios,
            agendas, catalogos y minisites publicos. Al crear una cuenta o utilizar la Plataforma, aceptas
            estos terminos en su totalidad.
        </p>

        <h2>1. Objeto</h2>
        <p>
            {{ config('app.name', 'Acerca.site') }} ofrece a personas y negocios un espacio para publicar una
            tarjeta digital con informacion de contacto, servicios, productos, ubicaciones y un minisite publico
            accesible por enlace o QR. Algunas funciones requieren suscripcion de pago segun el plan elegido.
        </p>

        <h2>2. Cuenta y registro</h2>
        <ul>
            <li>Debes proporcionar informacion veraz al registrarte y mantenerla actualizada.</li>
            <li>Eres responsable de la confidencialidad de tus credenciales y de toda actividad que ocurra bajo tu cuenta.</li>
            <li>El equipo de {{ config('app.name', 'Acerca.site') }} puede suspender cuentas que incumplan estos terminos o la legislacion vigente.</li>
        </ul>

        <h2>3. Uso permitido</h2>
        <p>Te comprometes a no utilizar la Plataforma para:</p>
        <ul>
            <li>Publicar contenido ilegal, fraudulento, difamatorio, obsceno o que vulnere derechos de terceros.</li>
            <li>Distribuir malware, spam o intentar accesos no autorizados a otros usuarios o a la infraestructura.</li>
            <li>Suplantar la identidad de personas, empresas o entidades.</li>
            <li>Recopilar datos de otros usuarios sin su consentimiento.</li>
        </ul>

        <h2>4. Contenido del usuario</h2>
        <p>
            Conservas la propiedad del contenido que publicas (textos, imagenes, logos, horarios). Al subirlo,
            nos otorgas una licencia no exclusiva para mostrarlo, almacenarlo y distribuirlo dentro de la
            Plataforma con el unico fin de prestar el servicio (incluyendo el minisite publico).
        </p>

        <h2>5. Planes, pagos y cancelacion</h2>
        <ul>
            <li>El plan gratuito permite usar funciones basicas sin coste.</li>
            <li>Los planes pagos se cobran por adelantado segun el periodo elegido y se renuevan automaticamente salvo cancelacion.</li>
            <li>Puedes cancelar en cualquier momento desde tu panel; el servicio pagado se mantendra activo hasta finalizar el periodo ya abonado.</li>
            <li>Salvo disposicion legal en contrario, los pagos no son reembolsables.</li>
        </ul>

        <h2>6. Limitacion de responsabilidad</h2>
        <p>
            La Plataforma se proporciona "tal cual". Hacemos esfuerzos razonables por mantenerla disponible
            y segura, pero no garantizamos disponibilidad ininterrumpida ni ausencia total de errores. No somos
            responsables del uso que terceros hagan del contenido publicado en tu minisite publico.
        </p>

        <h2>7. Cambios</h2>
        <p>
            Podemos actualizar estos Terminos para reflejar cambios legales o del producto. Te avisaremos por
            correo electronico o mediante un aviso visible dentro de la Plataforma. El uso continuado del
            servicio despues del cambio implica aceptacion de la nueva version.
        </p>

        <h2>8. Ley aplicable</h2>
        <p>
            Estos Terminos se rigen por la legislacion aplicable en el domicilio del titular de la Plataforma.
            Cualquier controversia se resolvera en los tribunales competentes de dicho domicilio.
        </p>

        <h2>9. Contacto</h2>
        <p>
            Para consultas sobre estos Terminos, escribenos a traves de la seccion de soporte disponible en
            <a href="{{ url('/login') }}">{{ url('/login') }}</a>.
        </p>
    </div>
@endsection