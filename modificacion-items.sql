
CREATE TABLE `items` (
  `id` int(11) NOT NULL,
  `idVenta` int(11) NOT NULL,
  `idCodigoFc` int(11) NOT NULL,
  `fecha` date NOT NULL,
  `nombreEscribano` text COLLATE utf8_spanish_ci NOT NULL,
  `nroComprobante` text COLLATE utf8_spanish_ci NOT NULL,
  `descripcionComprobante` text COLLATE utf8_spanish_ci NOT NULL,
  `folio1` text COLLATE utf8_spanish_ci NOT NULL,
  `folio2` text COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

ALTER TABLE `items`
  ADD PRIMARY KEY (`id`); 

ALTER TABLE `items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26690;