<div class="dropdown-divider">
    </div>
    <a class="dropdown-item" href="pesan">
        <!-- Message Start -->
        <div class="media">
                <div class="media-body">
                    <h3 class="dropdown-item-title">
                        <?=$sender;?>
                        <span class="float-right text-sm text-muted">
                            <i class="fas fa-star">
                            </i>
                        </span>
                    </h3>
                    <p class="text-sm" style="padding-top:10px;padding-bottom: 7px;border-radius: 10%;overflow-wrap: anywhere;">
                       <?=$content?>
                    </p>
                    <p class="text-sm text-muted">
                        <i class="far fa-clock mr-1">
                        </i>
                        <?=$value->create_date?>
                    </p>
                </div>
        </div>
        <!-- Message End -->
    </a>
