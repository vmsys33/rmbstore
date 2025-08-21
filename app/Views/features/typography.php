
<?= $this->extend('layout/layout'); ?>

<?= $this->section('content'); ?> 
    <div class="geex-content__section geex-content__typography">
        <div class="geex-content__typography__wrapper">
            <div class="geex-content__typography__wrapper__item d-flex justify-content-between gap-30">
                <!-- HEADING STYLE USING CLASS -->
                <div class="geex-content__typography__single d-flex flex-column gap-20">
                    <h1 class="geex-display-1">Display 1</h1>
                    <h1 class="geex-display-2">Display 2</h1>
                    <h1 class="geex-display-3">Display 3</h1>
                    <h1 class="geex-display-4">Display 4</h1>
                </div>
                <!-- HEADING STYLES -->
                <div class="geex-content__typography__single d-flex flex-column gap-20">
                    <h1>H1 Heading</h1>
                    <h2>H2 Heading</h2>
                    <h3>H3 Heading</h3>
                    <h4>H4 Heading</h4>
                    <h5>H5 Heading</h5>
                    <h6>H6 Heading</h6>
                </div>
                <!-- PARAGRAPH STYLES -->
                <div class="geex-content__typography__single d-flex flex-column gap-20">
                    <p>Paragraph Lead</p>
                    <p class="font-sm">Paragraph</p>
                    <p class="font-sm semi-bold">Paragraph Semi Bold</p>
                    <p class="font-sm bold">Paragraph Bold</p>
                    <p class="font-xs">Paragraph Small</p>
                    <p class="font-xs semi-bold">Paragraph Small Semi Bold</p>
                    <p class="font-xs bold">Paragraph Small Bold</p>
                    <p class="font-sm line-through">Delete</p>
                    <p class="font-sm italic">italicized</p>
                    <p class="font-sm underline">Underline</p>
                </div>
            </div>
        </div>
    </div>

<?= $this->endSection(); ?>