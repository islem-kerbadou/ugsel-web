import React, {useState} from 'react';
import {Championship} from '../../types';
import {Button} from '../common/Button';

interface ChampionshipCardProps {
    championship: Championship,
    onDelete: (id: number) => void,
    key?: number | undefined
}

export const ChampionshipCard: React.FC<ChampionshipCardProps> = ({
  championship,
  onDelete,
}) => {
  const [showDeleteConfirm, setShowDeleteConfirm] = useState(false);

  const handleDelete = () => {
    if (championship.id) {
      onDelete(championship.id);
      setShowDeleteConfirm(false);
    }
  };

  return (
    <div className="card mb-2">
      <div className="card-body d-flex justify-content-between align-items-center py-2">
        <span className="fw-medium">{championship.name}</span>
        <Button
          variant="danger"
          size="sm"
          onClick={() => setShowDeleteConfirm(true)}
        >
          Supprimer
        </Button>
      </div>

      {showDeleteConfirm && (
        <div className="alert alert-warning m-2 mb-0">
          <p className="mb-2 small">Supprimer ce championnat ?</p>
          <div className="d-flex gap-2">
            <Button variant="danger" size="sm" onClick={handleDelete}>
              Confirmer
            </Button>
            <Button variant="secondary" size="sm" onClick={() => setShowDeleteConfirm(false)}>
              Annuler
            </Button>
          </div>
        </div>
      )}
    </div>
  );
};
