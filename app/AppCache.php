<?php

use Symfony\Bundle\FrameworkBundle\HttpCache\HttpCache;

class AppCache extends HttpCache
{
    /**
     * The available options are:
     *
     *   * debug:                 If true, the traces are added as a HTTP header to ease debugging
     *
     *   * default_ttl            Le nombre de secondes pendant lesquelles une entrée du cache doit être considérée
     *                            comme « valide » quand il n’y a pas d’information explicite fournie dans une réponse.
     *                            Une valeur explicite pour les entêtes Cache-Control ou Expires surcharge cette valeur
     *                            (par défaut : 0);
     *
     *   * private_headers        Ensemble d’entêtes de requête qui déclenche le comportement « privé » du Cache-Control
     *                            pour les réponses qui ne précisent pas explicitement si elle sont publiques ou privées
     *                            via une directive du Cache-Control. (par défaut : Authorization et Cookie);
     *
     *   * allow_reload           Définit si le client peut forcer ou non un rechargement du cache en incluant une
     *                            directive du Cache-Control « no-cache » dans la requête. Définissez-la à true pour la
     *                            conformité avec la RFC 2616 (par défaut : false);
     *
     *   * allow_revalidate       Définit si le client peut forcer une revalidation du cache en incluant une directive
     *                            de Cache-Control « max-age=0 » dans la requête. Définissez-la à true pour la conformité
     *                            avec la RFC 2616 (par défaut : false);
     *
     *   * stale_while_revalidate Spécifie le nombre de secondes par défaut (la granularité est la seconde parce que le
     *                            TTL de la réponse est en seconde) pendant lesquelles le cache peut renvoyer une réponse
     *                            « périmée » alors que la nouvelle réponse est calculée en arrière-plan (par défaut : 2).
     *                            Ce paramètre est surchargé par l’extension HTTP stale-while-revalidate du Cache-Control
     *                            (cf. RFC 5861);
     *
     *   * stale_if_error         Spécifie le nombre de secondes par défaut (la granularité est la seconde) pendant
     *                            lesquelles le cache peut renvoyer une réponse « périmée » quand une erreur est rencontrée
     *                            (par défaut : 60). Ce paramètre est surchargé par l’extension HTTP stale-if-error du
     *                            Cache-Control (cf. RFC 5961).
     *
     */
    protected function getOptions()
    {
        return array(
            'debug' => true,
        );
    }
}
