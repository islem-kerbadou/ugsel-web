import React, {useState} from 'react';
import {Sport} from '../../types';
import {CompetitionList} from '../competitions/CompetitionList';
import {Button} from '../common/Button';

interface SportCardProps {
    sport: Sport,
    onDelete: (id: number) => void,
    key?: number | undefined
}

export const SportCard: React.FC<SportCardProps> = ({ sport, onDelete }) => {
  const [expanded, setExpanded] = useState(false);
  const [showDeleteConfirm, setShowDeleteConfirm] = useState(false);

  const handleDelete = () => {
    if (sport.id) {
      onDelete(sport.id);
      setShowDeleteConfirm(false);
    }
  };

  const sportTypeLabel = sport.sportType?.label || sport.sportType?.code || 'Non défini';
  const sportTypes = sport.sportType?.types || [];

  return (
    <div className="card mb-3">
      <div
        className="card-header bg-light d-flex justify-content-between align-items-center"
        style={{ cursor: 'pointer' }}
        onClick={() => setExpanded(!expanded)}
      >
        <div className="flex-grow-1">
          <h5 className="card-title mb-2">{sport.name}</h5>
          <div className="d-flex flex-wrap gap-2 align-items-center">
            <span className="badge bg-primary">{sportTypeLabel}</span>
            {sportTypes.length > 0 && (
              <>
                {sportTypes.map((type, idx) => (
                  <span key={idx} className="badge bg-secondary">
                    {type}
                  </span>
                ))}
              </>
            )}
            <small className="text-muted">
              {sport.competitions?.length || 0} compétition(s)
            </small>
          </div>
        </div>
        <div className="d-flex gap-2 align-items-center">
          <button
            className="btn btn-sm btn-link text-decoration-none"
            onClick={(e) => {
              e.stopPropagation();
              setExpanded(!expanded);
            }}
          >
            {expanded ? '▼' : '▶'}
          </button>
          <Button
            variant="danger"
            size="sm"
            onClick={(e) => {
              e?.stopPropagation();
              setShowDeleteConfirm(true);
            }}
          >
            Supprimer
          </Button>
        </div>
      </div>

      {showDeleteConfirm && (
        <div className="alert alert-warning m-3 mb-0">
          <p className="mb-2">Êtes-vous sûr de vouloir supprimer ce sport ?</p>
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

      {expanded && sport.id && (
        <div className="card-body">
          <CompetitionList sportId={sport.id} />
        </div>
      )}
    </div>
  );
};
