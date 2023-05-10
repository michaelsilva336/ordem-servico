<?php if(!empty($products_os)): ?>
                <?php foreach($products_os as $product_os): ?>
                    <?php if($product_os->services_orders_id === $os->id): ?>

                        <?php
                           $product= $productDao->findById($product_os->products_id);
                           
                           $product_os->id= $product_os->id;
                           $product_os->name= $product->name;
                           $product_os->qtd= $product_os->amount;
                           $product_os->unid= $product->unity;
                           $product_os->porcent_number= $product_os->porcent;
                           $product_os->price_pro= $product->value_buy;
                           $product_os->sub_total_pro= $product_os->sub_total;
                           $product_os->price_porcent= $product_os->porcent_price_sum;
                           $product_os->sub_total_porcent= $product_os->porcent_value_total;
                           $product_os->id_os= $product_os->services_orders_id;

                           $product_os->result_price= (($product_os->porcent_number / 100) * $product_os->price_pro) + $product_os->price_pro;
                           $product_os->result_total_porcent= $product_os->result_price * $product_os->qtd;

                           $productOsDao->update($product_os, false);

                        ?>

                        <div class="get-data">
                        <span><?="- "  . $product_os->name . " x" . $product_os->qtd . " | "  . $product_os->unid . " | " . " valor unit: " . "R$" . ($product_os->porcent_number <= 0 ? $numb= number_format($product_os->price_pro, 2, ',', '.') : $numb= number_format($product_os->price_porcent, 2, ',', '.'))  . " | Valor total: " . "R$" . ($product_os->porcent_number <= 0 ? $numb= number_format($product_os->sub_total_pro, 2, ',', '.') : $numb= number_format($product_os->sub_total_porcent, 2, ',', '.')) ?></span>
                        </div>

                        <?php 
                            $product_os->porcent_number <= 0 ? $value_pro += $product_os->sub_total_pro : $value_porcent += $product_os->sub_total_porcent; 
                            
                        ?>

                    <?php endif;?>
                <?php endforeach;?>
            <?php else: ?>
                <div>
                    <span>Nenhum produto adicionado!</span>
                </div>
            <?php endif; ?>

            <?php $osFinished;?>


            