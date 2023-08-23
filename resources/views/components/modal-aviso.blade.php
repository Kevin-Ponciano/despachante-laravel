<div class="modal modal-blur fade" id="modal-aviso" tabindex="-1" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
        <div class="modal-content">
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            <div class="modal-status bg-warning"></div>
            <div class="modal-body text-center py-4">
                <svg xmlns="http://www.w3.org/2000/svg" class="icon mb-2 text-warning icon-lg"
                     width="24" height="24" viewBox="0 0 24 24" stroke-width="1" stroke="currentColor" fill="none"
                     stroke-linecap="round" stroke-linejoin="round">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                    <path
                        d="M12 2c5.523 0 10 4.477 10 10a10 10 0 0 1 -19.995 .324l-.005 -.324l.004 -.28c.148 -5.393 4.566 -9.72 9.996 -9.72zm.01 13l-.127 .007a1 1 0 0 0 0 1.986l.117 .007l.127 -.007a1 1 0 0 0 0 -1.986l-.117 -.007zm-.01 -8a1 1 0 0 0 -.993 .883l-.007 .117v4l.007 .117a1 1 0 0 0 1.986 0l.007 -.117v-4l-.007 -.117a1 1 0 0 0 -.993 -.883z"
                        stroke-width="0" fill="currentColor"></path>
                </svg>
                <h3>Aviso</h3>
                <div class="text-secondary">
                    {{$slot}}
                </div>
            </div>
            <div class="modal-footer">
                <div class="w-100">
                    <div class="d-flex justify-content-center">
                        <div>
                            <a href="#" class="btn w-100" data-bs-dismiss="modal">
                                Fechar
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
